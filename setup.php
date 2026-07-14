<?php
$pageTitle = 'Setup check';
require __DIR__ . '/includes/header.php';

/** Try to create anything missing, then test it for real by writing a file. */
function check_path(string $path): array
{
    $existed = is_dir($path);
    if (!$existed) {
        @mkdir($path, 0777, true);
        @chmod($path, 0777);
    }

    $result = [
        'path'    => $path,
        'exists'  => is_dir($path),
        'perms'   => is_dir($path) ? substr(sprintf('%o', fileperms($path)), -4) : '—',
        'owner'   => '—',
        'writable'=> false,
        'created' => !$existed && is_dir($path),
    ];

    if (function_exists('posix_getpwuid') && is_dir($path)) {
        $info = @posix_getpwuid(fileowner($path));
        $result['owner'] = $info['name'] ?? (string)fileowner($path);
    }

    // is_writable() lies on some setups. Actually write something.
    if (is_dir($path)) {
        $probe = $path . '/.writetest';
        if (@file_put_contents($probe, 'ok') !== false) {
            $result['writable'] = true;
            @unlink($probe);
        }
    }
    return $result;
}

$checks = [
    'Orders'            => check_path(STORAGE_DIR),
    'Payment screenshots' => check_path(PROOF_DIR),
    'Stock file'        => check_path(dirname(STOCK_FILE)),
];

$phpUser = function_exists('posix_getpwuid')
    ? (posix_getpwuid(posix_geteuid())['name'] ?? 'unknown')
    : (getenv('USER') ?: 'unknown');

$allOk    = !in_array(false, array_column($checks, 'writable'), true);
$root     = dirname(STORAGE_DIR);
$uploadOk = (bool)ini_get('file_uploads');
$maxSize  = ini_get('upload_max_filesize');
?>
<main class="mx-auto max-w-3xl px-5 py-14">
  <h1 class="font-display text-4xl font-bold">Setup check</h1>
  <p class="mt-2 text-cocoa">Run this once after moving the folder. It tries to create what is missing, then writes a real file to prove it works.</p>

  <div class="mt-8 rounded-3xl border-2 <?= $allOk ? 'border-green bg-greenlt' : 'border-jam bg-white' ?> p-6">
    <p class="font-display text-2xl font-bold"><?= $allOk ? 'Everything is writable. You are good to go.' : 'PHP cannot write to storage.' ?></p>
    <?php if (!$allOk): ?>
      <p class="mt-2 text-sm">
        Apache runs as <span class="font-mono font-semibold"><?= e($phpUser) ?></span>, but the folder belongs to someone else,
        so PHP is not allowed to save orders. PHP cannot fix this itself — the permission has to come from the operating system.
      </p>
      <p class="mt-4 font-mono text-xs uppercase tracking-widest">Paste this into Terminal</p>
      <pre class="mt-2 overflow-x-auto rounded-2xl border-2 border-ink bg-ink p-4 font-mono text-xs text-white">cd <?= e($root) ?>
chmod -R 777 .</pre>
      <p class="mt-3 text-xs text-cocoa">
        Still failing? Give the folder to Apache outright:
        <span class="font-mono">sudo chown -R <?= e($phpUser) ?> <?= e($root) ?></span>
      </p>
      <p class="mt-2 text-xs text-cocoa">777 is fine on localhost. On a live server use 775 with the web server as group owner, and block browser access to storage/.</p>
    <?php endif; ?>
  </div>

  <table class="mt-8 w-full border-collapse overflow-hidden rounded-2xl border-2 border-ink text-sm">
    <thead class="bg-white">
      <tr class="border-b-2 border-ink text-left font-mono text-xs uppercase tracking-widest text-cocoa">
        <th class="px-4 py-3">What</th>
        <th class="px-4 py-3">Perms</th>
        <th class="px-4 py-3">Owner</th>
        <th class="px-4 py-3">Writable</th>
      </tr>
    </thead>
    <tbody class="bg-white">
      <?php foreach ($checks as $label => $c): ?>
        <tr class="border-b border-line last:border-0">
          <td class="px-4 py-3">
            <span class="font-semibold"><?= e($label) ?></span>
            <span class="block font-mono text-xs text-cocoa"><?= e($c['path']) ?></span>
            <?php if ($c['created']): ?><span class="font-mono text-xs text-green">created just now</span><?php endif; ?>
          </td>
          <td class="px-4 py-3 font-mono"><?= e($c['perms']) ?></td>
          <td class="px-4 py-3 font-mono"><?= e($c['owner']) ?></td>
          <td class="px-4 py-3 font-mono <?= $c['writable'] ? 'text-green' : 'text-jam' ?>">
            <?= $c['writable'] ? 'yes' : 'NO' ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <div class="mt-6 rounded-2xl border-2 border-line bg-white p-5 text-sm">
    <p class="font-mono text-xs uppercase tracking-widest text-cocoa">Also worth knowing</p>
    <ul class="mt-2 space-y-1 text-cocoa">
      <li>PHP <?= e(PHP_VERSION) ?> · running as <span class="font-mono"><?= e($phpUser) ?></span></li>
      <li>File uploads: <span class="font-mono <?= $uploadOk ? 'text-green' : 'text-jam' ?>"><?= $uploadOk ? 'on' : 'OFF — payment screenshots will fail' ?></span>, max <?= e($maxSize) ?></li>
      <li>Delete this file before you go live — it tells strangers how your server is set up.</li>
    </ul>
  </div>

  <a href="index.php" class="mt-10 inline-block rounded-full border-2 border-ink bg-green px-6 py-3 font-semibold text-white hover:bg-greendk">Back to the shop</a>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
