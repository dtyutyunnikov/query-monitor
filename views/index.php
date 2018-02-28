<h1>Last Queries</h1>
<form method="post" action="<?php echo $status ? '/disable' : '/enable'; ?>" class="my-3 text-center">
    <input type="submit" class="btn" name="mode" value="Enable"<?php echo $status ? 'disabled="disabled"' : ''; ?>>
    <input type="submit" class="btn" name="mode" value="Disable"<?php echo $status ? '' : 'disabled="disabled"'; ?>>
</form>
<table class="table">
    <tr>
        <th>Time</th>
        <th>Queries</th>
    </tr>
    <?php foreach ($rows as $row): ?>
    <tr>
        <td><?php echo $row->time; ?></td>
        <td><a href="/threads/<?php echo $row->id; ?>"><?php echo $row->queries; ?></a></td>
    </tr>
    <?php endforeach; ?>
</table>
