<form method="POST" action="?c=currency&m=exchange">
    <label for="source"><strong>Waluta źródłowa</strong></label>
    <select id="source" class="form-select mt-1" name="source_currency_code" required>
        <?php foreach ($currencies as $currency): ?>
            <option value="<?= $currency['currency_code'] ?>"><?= "{$currency['currency_code']} - {$currency['currency_name']}" ?></option>
        <?php endforeach; ?>
    </select>

    <label for="target" class="mt-2"><strong>Waluta docelowa</strong></label>
    <select id="target" class="form-select mt-1" name="target_currency_code" required>
        <?php foreach ($currencies as $currency): ?>
            <option value="<?= $currency['currency_code'] ?>"><?= "{$currency['currency_code']} - {$currency['currency_name']}" ?></option>
        <?php endforeach; ?>
    </select>

    <label for="amount" class="mt-2"><strong>Wpisz kwotę</strong></label>
    <input type="text" id="amount" name="amount" class="form-control mt-1" pattern="\d+(?:[.,]\d{1,2})?" placeholder="Maksymalnie 2 liczby po przecinku" required>
    <button type="submit" class="btn btn-success mt-2">Oblicz</button>
</form>

<?php if (!empty($exchanges)): ?>
<h2 class="mt-4">Wyniki ostatnich 10 przewalutowań</h2>
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Lp.</th>
            <th>Kod waluty źródłowej</th>
            <th>Nazwa waluty źródłowej</th>
            <th>Kod waluty docelowej</th>
            <th>Nazwa waluty docelowej</th>
            <th>Kwota</th>
            <th>Kurs</th>
            <th>Wynik przewalutowania</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=1; foreach ($exchanges as $exchange): ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $exchange['source_currency_code'] ?></td>
                <td><?= $exchange['source_currency_name'] ?></td>
                <td><?= $exchange['target_currency_code'] ?></td>
                <td><?= $exchange['target_currency_name'] ?></td>
                <td><?= $exchange['amount'] ?></td>
                <td><?= $exchange['exchange_rate'] ?></td>
                <td><?= $exchange['exchange_result'] ?></td>
            </tr>
        <?php $i++; endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<h2 class="mt-4">Brak historii przewalutowań</h2>
<?php endif; ?>