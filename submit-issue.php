<?php
// Konfiguration
define('GITHUB_TOKEN', 'ghp_YOUR_PERSONAL_ACCESS_TOKEN'); // Skapa en Fine-grained PAT i GitHub
define('GITHUB_REPO_OWNER', 'ditt-github-anvandarnamn');
define('GITHUB_REPO_NAME', 'swish-katalogen');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Tvätta input
    $swishNumber = filter_input(INPUT_POST, 'swish_number', FILTER_SANITIZE_NUMBER_INT);
    $orgName     = trim(filter_input(INPUT_POST, 'org_name', FILTER_SANITIZE_SPECIAL_CHARS));
    $orgNumber   = filter_input(INPUT_POST, 'org_number', FILTER_SANITIZE_NUMBER_INT);

    // Enkel rensning från eventuella bindestreck eller mellanslag
    $swishNumber = preg_replace('/\D/', '', $swishNumber);
    $orgNumber   = preg_replace('/\D/', '', $orgNumber);

    // 2. Valideringsfunktioner
    
    // Luhn-10 algoritm (används för både Swish och Org.nr)
    function validateLuhn($number) {
        $sum = 0;
        $numDigits = strlen($number);
        $parity = $numDigits % 2;
        
        for ($i = 0; $i < $numDigits; $i++) {
            $digit = (int)$number[$i];
            if ($i % 2 == $parity) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }
            $sum += $digit;
        }
        return ($sum % 10 === 0);
    }

    // Validera Swish 123-nummer
    function isValidSwishNumber($num) {
        // Måste vara exakt 10 siffror och börja på 123
        if (!preg_match('/^123\d{7}$/', $num)) {
            return false;
        }
        
        // Får inte tillhöra de ogiltiga serierna 123 7XX eller 123 8XX
        $series = (int)substr($num, 3, 3);
        if ($series >= 700 && $series <= 899) {
            return false;
        }

        // Måste klara Luhn-10
        return validateLuhn($num);
    }

    // Validera Svenskt Organisationsnummer
    function isValidOrgNumber($num) {
        // Omvandla 12-siffrigt (16XXXXXXXXXX) till 10-siffrigt
        if (strlen($num) === 12 && (strpos($num, '16') === 0)) {
            $num = substr($num, 2);
        }

        if (!preg_match('/^\d{10}$/', $num)) {
            return false;
        }

        // Måste ha en mellansiffra >= 2 för att vara juridisk person/förening (inte personnummer)
        $middleDigit = (int)$num[2];
        if ($middleDigit < 2) {
            return false; 
        }

        return validateLuhn($num);
    }

    // 3. Utför valideringar på servern
    if (empty($orgName) || strlen($orgName) < 2) {
        $response['message'] = 'Vänligen ange ett giltigt organisationsnamn.';
    } elseif (!isValidSwishNumber($swishNumber)) {
        $response['message'] = 'Ogiltigt Swish-nummer. Det måste vara 10 siffror, börja på 123 och vara matematiskt korrekt.';
    } elseif (!isValidOrgNumber($orgNumber)) {
        $response['message'] = 'Ogiltigt organisationsnummer. Kontrollera sifferkombinationen.';
    } else {
        
        // 4. Bygg payload till GitHub API
        $formattedSwish = substr($swishNumber, 0, 3) . ' ' . substr($swishNumber, 3, 3) . ' ' . substr($swishNumber, 6, 3) . ' ' . substr($swishNumber, 9, 1);
        $formattedOrg   = substr($orgNumber, 0, 6) . '-' . substr($orgNumber, 6, 4);

        $issueTitle = "Nytt nummer: {$orgName} ({$formattedSwish})";
        $issueBody  = "Ett nytt Swish-nummer har skickats in via webbformuläret:\n\n" .
                      "- **Organisation:** {$orgName}\n" .
                      "- **Swish-nummer:** `{$formattedSwish}`\n" .
                      "- **Organisationsnummer:** `{$formattedOrg}`\n\n" .
                      "_Detta nummer har automatvaliderats med Luhn-10 på server-sidan._";

        $data = [
            'title'  => $issueTitle,
            'body'   => $issueBody,
            'labels' => ['nytt-nummer', 'user-submission']
        ];

        // 5. Skicka till GitHub via cURL
        $ch = curl_init("https://api.github.com/repos/" . GITHUB_REPO_OWNER . "/" . GITHUB_REPO_NAME . "/issues");
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'User-Agent: Swish-Katalogen-Form',
            'Authorization: Bearer ' . GITHUB_TOKEN,
            'Accept: application/vnd.github+json',
            'Content-Type: application/json'
        ]);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 201) {
            $response['success'] = true;
            $response['message'] = 'Tack! Numret har validerats och lagts till i vår granskningskö på GitHub.';
        } else {
            $response['message'] = 'Ett tekniskt fel uppstod när ärendet skulle skickas till GitHub.';
        }
    }
}
?>
