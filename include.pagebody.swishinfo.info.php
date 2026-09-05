
  <h2>Swish-nummer för Företag & Föreningar (123-serien): Teknisk Information</h2>

  <p>Denna sida förklarar den tekniska och matematiska uppbyggnaden av Swish-nummer som tillhör företag, föreningar och organisationer, samt hur nummerserierna är uppdelade i den svenska nummerplanen.</p>


  <h3>1. Nummerstruktur & Luhn-10-algoritmen</h3>

  <p>Alla företagskopplade Swish-nummer är virtuella identifierare (saknar SIM-kort/mobilabonnemang) bestående av exakt <b>10 siffror</b>. Uppbyggnaden följer en strikt <b>3 + 6 + 1</b>-modell:</p>

```
  [1 2 3]      [X X X X X X]         [C]
  Prefix        Serienummer     Kontrollsiffra
(3 siffror)     (6 siffror)      (1 siffra)

```

  <h4>Komponenter</h4>

  <ul>
    <li>Prefix &quot;123&quot;</li>
    <li>Serienummer (6 siffror): Löpnummer/sekvensnummer som tilldelas av bankerna.</li>
    <li>Kontrollsiffra <b>C</b> (Position 10): Beräknas automatiskt utifrån de 9 första siffrorna med hjälp av <b>Luhn-algoritmen (Modulus 10)</b>.</li>
  </ul>

  <p>Matematisk effekt: Eftersom Luhn-10-algoritmen ger exakt <b>1 unikt godkänd kontrollsiffra</b> för varje kombination av de 6 siffrorna i serienummret, finns det exakt lika många giltiga Swish-nummer som det finns unika 6-siffriga serienummer inom de tillåtna intervallen.



  <h3>2. Komplett översikt över Nummerserier</h3>

  <p>Swish 123-rymden omfattar totalt <b>710 000 teoretiska 10-siffriga kombinationer</b>. Nedan är hela nummersystemet nedbrutet i jämna 100-tal utifrån de 6-siffriga serienumren 123 XXX XXX C.</p>

  <h4>Standardserier: Företag, Föreningar & Handel</h4>

  <p>Aktiva serier som tilldelas löpande av bankerna för vanliga kommersiella och föreningsrelaterade betalningar.</p>

  <table>
    <tr>
      <th>Serie Start (Prefix + Block)</th>
      <th>Serie Slut (Prefix + Block)</th>
      <th>Status / Beskrivning</th>
      <th>Max teoretiska nummer</th>
      <th>Antal i Swish-Katalogen</th>
    </tr>
    <tr>
      <td>123 000 00 00</td>
      <td>123 099 99 99</td>
      <td>Aktiv Standardserie</td>
      <td>100000</td>
      <td id="swish-0">0</td>
    </tr>
    <tr>
      <td>123 100 00 00</td>
      <td>123 199 99 99</td>
      <td>Aktiv Standardserie</td>
      <td>100000</td>
      <td id="swish-1">0</td>
    </tr>
    <tr>
      <td>123 200 00 00</td>
      <td>123 299 99 99</td>
      <td>Aktiv Standardserie</td>
      <td>100000</td>
      <td id="swish-2">0</td>
    </tr>
    <tr>
      <td>123 300 00 00</td>
      <td>123 399 99 99</td>
      <td>Aktiv Standardserie</td>
      <td>100000</td>
      <td id="swish-3">0</td>
    </tr>
    <tr>
      <td>123 400 00 00</td>
      <td>123 499 99 99</td>
      <td>Aktiv Standardserie</td>
      <td>100000</td>
      <td id="swish-4">0</td>
    </tr>
    <tr>
      <td>123 500 00 00</td>
      <td>123 599 99 99</td>
      <td>Aktiv Standardserie</td>
      <td>100000</td>
      <td id="swish-5">0</td>
    </tr>
    <tr>
      <td>123 600 00 00</td>
      <td>123 699 99 99</td>
      <td>Aktiv Standardserie</td>
      <td>100000</td>
      <td id="swish-6">0</td>
    </tr>
    <tr>
      <td>123 700 00 00</td>
      <td>123 799 99 99</td>
      <td>Oallokerad</td>
      <td>0</td>
      <td>0</td>
    </tr>
    <tr>
      <td>123 800 00 00</td>
      <td>123 899 99 99</td>
      <td>Oallokerad</td>
      <td>0</td>
      <td>0</td>
    </tr>
    <tr>
      <td>123 900 00 00</td>
      <td>123 909 99 99</td>
      <td>Skyddade 90-konton</td>
      <td>10000</td>
      <td id="swish-9">0</td>
    </tr>
    <tr>
      <td>123 910 00 00</td>
      <td>123 999 99 99</td>
      <td>Oallokerad</td>
      <td>0</td>
      <td>0</td>
    </tr>
  
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td>710000</td>
      <td id="swish-total">0</td>
    </tr>

    </tr>
  </table>


  <h4>900-blocket: Skyddade 90-konton & Övrigt</h4>

*Serier reserverade för ideella insamlingsorganisationer som granskas av Svensk Insamlingskontroll samt reserverade utrymmen.*

| Serie (Prefix + Block) | Status / Beskrivning | Max teoretiska nummer | Antal i Swish-Katalogen |
| --- | --- | --- | --- |
| **`123 900` – `123 909**` | **Skyddade 90-konton** (Svensk Insamlingskontroll) | 10 000 | *[Fyll i]* |
| **`123 910` – `123 999**` | Ej tilldelade / Övrigt i 900-blocket | 90 000 | *[Fyll i]* |
| **Subtotal (900-block)** | **Totalt inom 900-blocket** | **100 000** | **[Fyll i]** |

---

<h3>3. Totalt summerad nummerrymd för Swish 123</h3>

| Kategori | Antal unika 6-siffriga serier | Totalt antal giltiga Swish-nummer | Antal indexerade i Swish-Katalogen | Täckningsgrad (%) |
| --- | --- | --- | --- | --- |
| **Standard Företag/Förening** | 700 000 | 700 000 | *[Fyll i]* | *[Fyll i]* % |
| **Skyddade 90-konton** | 10 000 | 10 000 | *[Fyll i]* | *[Fyll i]* % |
| **Övrigt/Ej tilldelat i 900-blocket** | 90 000 | 90 000 | *[Fyll i]* | *[Fyll i]* % |
| **Spärrat/Oallokerat (700 & 800)** | 200 000 | 0 | 0 | 0 % |
| **TOTALT (123-serien)** | **1 000 000** | **800 000** | **[Fyll i]** | **[Fyll i] %** |

