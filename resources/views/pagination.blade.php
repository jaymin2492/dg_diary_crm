<?php
$paginationLinks = $items->toArray();
$paginationLinks = $paginationLinks['links'];
if (!empty($paginationLinks)) {
?>
<ul class="pagination pagination-rounded justify-content-end mb-0">
    <?php foreach ($paginationLinks as $paginationLink) { ?>
        <li class="page-item <?php if ($paginationLink['active'] == "1") { ?> active<?php } ?> <?php if (empty($paginationLink['url'])) { ?>disabled <?php } ?>">
            <a class="page-link" href="<?php echo $paginationLink['url']; ?>" tabindex="-1"><?php echo $paginationLink['label']; ?></a>
        </li>
    <?php } ?>
</ul>
<?php } ?>