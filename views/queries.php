<h1>Last Queries</h1>
<table class="table">
    <tr>
        <th>Queries</th>
    </tr>
    <?php foreach ($rows as $row): ?>
    <tr>
        <?php
            $syntax = [
                '/\b(SELECT|UPDATE|DELETE|SHOW|ALTER|USE)\b/i' => '<strong>$1</strong>',
                '/\b(FROM|SET|WHERE|ORDER BY|GROUP BY|LIMIT|LEFT JOIN|INNER JOIN)\b/i' => '<strong>$1</strong>',
                '/\b(AND|OR|ON|IN)\b/' => '<u>$1</u>',
            ]
        ?>
        <td><code><?php echo preg_replace(array_keys($syntax), array_values($syntax), $row->argument); ?></code></td>
    </tr>
    <?php endforeach; ?>
</table>