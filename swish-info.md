
---

# Swish-nummer för Företag & Föreningar (123-serien): Teknisk Specifikation

Denna sida förklarar den tekniska och matematiska uppbyggnaden av Swish-nummer som tillhör företag, föreningar och organisationer, samt hur nummerserierna är uppdelade i den svenska nummerplanen.

---

## 1. Nummerstruktur & Luhn-10-algoritmen

Alla företagskopplade Swish-nummer är virtuella identifierare (saknar SIM-kort/mobilabonnemang) bestående av exakt **10 siffror**. Uppbyggnaden följer en strikt **`3 + 6 + 1`**-modell:

```
  [1 2 3]      [X X X X X X]         [C]
  Prefix        Serienummer     Kontrollsiffra
(3 siffror)     (6 siffror)      (1 siffra)

```

### Komponenter

* **Prefix (`123`):** Reserverat i nummerplanen av Post- och telestyrelsen (PTS) för *Swish Företag & Handel*.
* **Serienummer (6 siffror):** Löpnummer/sekvensnummer som tilldelas av bankerna.
* **Kontrollsiffra `C` (Position 10):** Beräknas automatiskt utifrån de 9 första siffrorna med hjälp av **Luhn-algoritmen (Modulus 10)**.

> **Matematisk effekt:** Eftersom Luhn-10-algoritmen ger exakt **1 unikt godkänd kontrollsiffra** för varje kombination av de 9 första siffrorna, finns det exakt lika många giltiga Swish-nummer som det finns unika 6-siffriga serienummer inom de tillåtna intervallen.

---

## 2. Komplett översikt över Nummerserier

Swish 123-rymden omfattar totalt **1 000 000 teoretiska 10-siffriga kombinationer**. Nedan är hela nummersystemet nedbrutet i jämna 100-tal utifrån de 6-siffriga serienumren (`123 XXX XXX C`).

### Standardserier: Företag, Föreningar & Handel

*Aktiva serier som tilldelas löpande av bankerna för vanliga kommersiella och föreningsrelaterade betalningar.*

| Serie (Prefix + Block) | Status / Beskrivning | Max teoretiska nummer | Antal i Swish-Katalogen |
| --- | --- | --- | --- |
| **`123 000` – `123 099**` | Aktiv Standardserie | 100 000 | *[Fyll i]* |
| **`123 100` – `123 199**` | Aktiv Standardserie | 100 000 | *[Fyll i]* |
| **`123 200` – `123 299**` | Aktiv Standardserie | 100 000 | *[Fyll i]* |
| **`123 300` – `123 399**` | Aktiv Standardserie | 100 000 | *[Fyll i]* |
| **`123 400` – `123 499**` | Aktiv Standardserie | 100 000 | *[Fyll i]* |
| **`123 500` – `123 599**` | Aktiv Standardserie | 100 000 | *[Fyll i]* |
| **`123 600` – `123 699**` | Aktiv Standardserie | 100 000 | *[Fyll i]* |
| **Subtotal (Standard)** | **Totalt aktiva standardserier** | **700 000** | **[Fyll i]** |

---

### Oallokerade & Ogiltiga serier

*Spärrade eller reserverade nummerserier som saknar aktiva kopplingar hos bankerna. Filtreras bort direkt av Swish-appens klientvalidering.*

| Serie (Prefix + Block) | Status / Beskrivning | Max teoretiska nummer | Antal i Swish-Katalogen |
| --- | --- | --- | --- |
| **`123 700` – `123 799**` | Ogiltig / Oallokerad | 0 *(100 000 spärrade)* | 0 |
| **`123 800` – `123 899**` | Ogiltig / Oallokerad | 0 *(100 000 spärrade)* | 0 |
| **Subtotal (Spärrat)** | **Totalt spärrade/oallokerade nummer** | **0** | **0** |

---

### 900-blocket: Skyddade 90-konton & Övrigt

*Serier reserverade för ideella insamlingsorganisationer som granskas av Svensk Insamlingskontroll samt reserverade utrymmen.*

| Serie (Prefix + Block) | Status / Beskrivning | Max teoretiska nummer | Antal i Swish-Katalogen |
| --- | --- | --- | --- |
| **`123 900` – `123 909**` | **Skyddade 90-konton** (Svensk Insamlingskontroll) | 10 000 | *[Fyll i]* |
| **`123 910` – `123 999**` | Ej tilldelade / Övrigt i 900-blocket | 90 000 | *[Fyll i]* |
| **Subtotal (900-block)** | **Totalt inom 900-blocket** | **100 000** | **[Fyll i]** |

---

## 3. Totalt summerad nummerrymd för Swish 123

| Kategori | Antal unika 6-siffriga serier | Totalt antal giltiga Swish-nummer | Antal indexerade i Swish-Katalogen | Täckningsgrad (%) |
| --- | --- | --- | --- | --- |
| **Standard Företag/Förening** | 700 000 | 700 000 | *[Fyll i]* | *[Fyll i]* % |
| **Skyddade 90-konton** | 10 000 | 10 000 | *[Fyll i]* | *[Fyll i]* % |
| **Övrigt/Ej tilldelat i 900-blocket** | 90 000 | 90 000 | *[Fyll i]* | *[Fyll i]* % |
| **Spärrat/Oallokerat (700 & 800)** | 200 000 | 0 | 0 | 0 % |
| **TOTALT (123-serien)** | **1 000 000** | **800 000** | **[Fyll i]** | **[Fyll i] %** |

---

## 4. Det tekniska betalflödet i korthet

1. **Klientvalidering:** Swish-appen verifierar att numret startar på `123`, inte tillhör de spärrade serierna (`700–899`) samt att den tionde siffran stämmer överens med **Luhn-10-kalkylen**.
2. **Centralt Alias-uppslag:** Appen gör ett anrop till Getswish centrala API och slår upp aliaset (`123XXXXXXX`).
3. **Mottagarvalidering:** Systemet returnerar det registrerade företagsnamnet (som det står hos Bolagsverket/Skatteverket) till appen.
4. **Signering & Realtime-Clearing:** Betalaren godkänner namnet med Mobilt BankID, varpå pengarna flyttas direkt via Riksbankens betalsystem (**RIX-INST**) till mottagarens företagskonto.
