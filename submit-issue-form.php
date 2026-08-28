<form action="submit-issue.php" method="POST" class="swish-submit-form">
    
    <?php if (!empty($response['message'])): ?>
        <div class="alert <?php echo $response['success'] ? 'alert-success' : 'alert-error'; ?>">
            <?php echo $response['message']; ?>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <label for="org_name">Organisation / Företagsnamn:</label>
        <input type="text" id="org_name" name="org_name" placeholder="t.ex. Röda Korset" required>
    </div>

    <div class="form-group">
        <label for="swish_number">Swish-nummer (10 siffror):</label>
        <input type="text" id="swish_number" name="swish_number" placeholder="123 XXX XX XX" maxlength="12" required>
        <small>Måste börja på 123</small>
    </div>

    <div class="form-group">
        <label for="org_number">Organisationsnummer:</label>
        <input type="text" id="org_number" name="org_number" placeholder="XXXXXX-XXXX" maxlength="13" required>
    </div>

    <button type="submit">Skicka in för granskning</button>
</form>
