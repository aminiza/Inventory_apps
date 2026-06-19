<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(2);

$current = (int)$pager->getCurrent();
$last = (int)$pager->getLast();
?>

<?php if ($pager): ?>
<nav aria-label="Pagination">
  <ul class="flex flex-wrap items-center space-x-1">
    <!-- Previous -->
    <?php if ($pager->hasPrevious()): ?>
      <li>
        <a href="<?= $pager->getPrevious() ?>" class="px-3 py-2 rounded-md bg-white border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50">
          &laquo; Prev
        </a>
      </li>
    <?php else: ?>
      <li>
        <span class="px-3 py-2 rounded-md bg-gray-100 border border-gray-200 text-sm font-medium text-gray-500 cursor-not-allowed">
          &laquo; Prev
        </span>
      </li>
    <?php endif; ?>

    <!-- First & Ellipsis -->
    <?php if ($current > 3): ?>
      <li>
        <a href="<?= $pager->getFirst() ?>" class="px-3 py-2 rounded-md bg-white border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50">1</a>
      </li>
      <?php if ($current > 4): ?>
        <li class="px-3 py-2 text-gray-500">...</li>
      <?php endif; ?>
    <?php endif; ?>

    <!-- Links -->
    <?php foreach ($pager->links() as $link): ?>
      <?php if ($link['active']): ?>
        <li>
          <span class="px-3 py-2 rounded-md bg-blue-600 border border-blue-600 text-sm font-medium text-white"><?= $link['title'] ?></span>
        </li>
      <?php else: ?>
        <li>
          <a href="<?= $link['uri'] ?>" class="px-3 py-2 rounded-md bg-white border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50"><?= $link['title'] ?></a>
        </li>
      <?php endif; ?>
    <?php endforeach; ?>

    <!-- Last & Ellipsis -->
    <?php if ($current < $last - 2): ?>
      <?php if ($current < $last - 3): ?>
        <li class="px-3 py-2 text-gray-500">...</li>
      <?php endif; ?>
      <li>
        <a href="<?= $pager->getLast() ?>" class="px-3 py-2 rounded-md bg-white border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50"><?= $pager->getLast() ?></a>
      </li>
    <?php endif; ?>

    <!-- Next -->
    <?php if ($pager->hasNext()): ?>
      <li>
        <a href="<?= $pager->getNext() ?>" class="px-3 py-2 rounded-md bg-white border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50">
          Next &raquo;
        </a>
      </li>
    <?php else: ?>
      <li>
        <span class="px-3 py-2 rounded-md bg-gray-100 border border-gray-200 text-sm font-medium text-gray-500 cursor-not-allowed">
          Next &raquo;
        </span>
      </li>
    <?php endif; ?>
  </ul>
</nav>
<?php endif; ?>