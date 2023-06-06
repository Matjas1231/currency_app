<div>
    <p>
        <a href="?c=currency&m=downloadFromApi" class="btn btn-sm btn-primary">Pobierz kursy walut</a>
        <?php if ($currencies): ?>
            <a href="?c=currency&m=exchangeForm" class="btn btn-sm btn-success">Kalkulator wymiany</a>
        <?php endif; ?>
    </p>
</div>

    <div>
        <?php if ($currencies): ?>
            <table class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Lp.</th>
                        <th>Kod</th>
                        <th>Nazwa</th>
                        <th>Średni kurs wymiany</th>
                        <th>Data ustalenia kursu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach ($currencies as $currency): ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $currency['currency_code'] ?></td>
                        <td><?= $currency['currency_name'] ?></td>
                        <td><?= $currency['exchange_rate'] ?></td>
                        <td><?= $currency['effective_date'] ?></td>
                    </tr>
                    <?php $i++; endforeach; ?>
                </tbody>
            </table>

        <?php else: ?>
            <h2>Brak pobranych kursów walut</h2>
        <?php endif; ?>
    </div>
