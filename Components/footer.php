<?php
if (!isset($current_page)) {
    $current_page = 'tentang-kami';
}

$script_name = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
if (preg_match('#^(.*?)/(Pages|api|Components)#', $script_name, $matches)) {
    $base_url = $matches[1];
} else {
    $base_url = rtrim(dirname($script_name), '/\\');
    if ($base_url === '/' || $base_url === '\\') {
        $base_url = '';
    }
}

$footerBrand = 'JTI NOVA';
$footerDesc  = 'Teaching Factory Jurusan Teknologi Informasi Politeknik Negeri Jember: solusi digital, pelatihan, dan pendampingan berbasis proyek nyata.';

$footerLinks = [
    ['key' => 'tentang-kami', 'label' => 'Tentang Kami', 'file' => 'tentang-kami.php'],
    ['key' => 'pelayanan',    'label' => 'Pelayanan',    'file' => 'pelayanan.php'],
    ['key' => 'pelatihan',    'label' => 'Pelatihan',    'file' => 'pelatihan.php'],
    ['key' => 'portofolio',   'label' => 'Portofolio',   'file' => 'portofolio.php'],
    ['key' => 'tim',          'label' => 'Tim',          'file' => 'tim.php'],
];

$footerAlamat  = 'Politeknik Negeri Jember, Jl. Mastrip, Sumbersari, Jember, Jawa Timur';
$footerTelepon = '+62 812-0000-0000';
$footerEmail   = 'info@jtinova.com';
?>

<style>
  .site-footer {
    background-color: var(--bg-dark);
    color: var(--bg-gray);
    padding-top: calc(var(--space-48) + var(--space-16));
    font-family: 'Inter', sans-serif;
  }

  .site-footer__grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: var(--space-48);
    padding-bottom: var(--space-48);
  }

  .site-footer__brand {
    margin: 0 0 var(--space-16);
    color: var(--bg-white);
    font-weight: 700;
  }

  .site-footer__desc {
    margin: 0;
    font-size: 14px;
    line-height: 1.2;
    color: var(--bg-gray);
  }

  .site-footer__title {
    margin: 0 0 var(--space-16);
    color: var(--bg-white);
  }

  .site-footer__title--spaced {
    margin-top: var(--space-24);
  }

  .site-footer__list {
    list-style: none;
    margin: 0;
    padding: 0;
  }

  .site-footer__list li {
    margin-bottom: var(--space-8);
  }

  .site-footer__text,
  .site-footer a {
    display: block;
    margin: 0 0 var(--space-8);
    font-size: 14px;
    font-weight: 400;
    line-height: 1.4;
    color: var(--bg-gray);
    text-decoration: none;
    transition: color 0.2s ease;
  }

  .site-footer__list a {
    margin-bottom: 0;
  }

  .site-footer a:hover {
    color: var(--bg-white);
    text-decoration: underline;
  }

  .site-footer a.is-active {
    color: var(--bg-white);
    font-weight: 600;
  }

  .site-footer a:focus-visible {
    outline: 2px solid var(--brand-teal);
    outline-offset: 3px;
    border-radius: var(--radius-badge);
  }

  .site-footer__bottom {
    border-top: 1px solid var(--text-secondary);
    padding: var(--space-24) 0 var(--space-48);
    color: var(--bg-gray);
  }

  @media (max-width: 1024px) {
    .site-footer .container {
      padding-left: var(--space-24);
      padding-right: var(--space-24);
    }
  }

  @media (max-width: 768px) {
    .site-footer__grid {
      grid-template-columns: 1fr;
      gap: var(--space-24);
    }
  }
</style>

<footer class="site-footer">
  <div class="container">

    <div class="site-footer__grid">

      <div>
        <h3 class="heading-3 site-footer__brand"><?= htmlspecialchars($footerBrand) ?></h3>
        <p class="site-footer__desc"><?= htmlspecialchars($footerDesc) ?></p>
      </div>

      <nav aria-label="Quick Links">
        <h4 class="label site-footer__title">Quick Links</h4>
        <ul class="site-footer__list">
          <?php foreach ($footerLinks as $link): ?>
            <?php $isActive = ($current_page === $link['key']); ?>
            <li>
              <a href="<?= htmlspecialchars($base_url . '/Pages/' . $link['file']) ?>"
                 <?= $isActive ? 'class="is-active" aria-current="page"' : '' ?>>
                <?= htmlspecialchars($link['label']) ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </nav>

      <div>
        <h4 class="label site-footer__title">Alamat</h4>
        <p class="site-footer__text"><?= htmlspecialchars($footerAlamat) ?></p>

        <h4 class="label site-footer__title site-footer__title--spaced">Kontak</h4>
        <a href="tel:<?= preg_replace('/[^+\d]/', '', $footerTelepon) ?>"><?= htmlspecialchars($footerTelepon) ?></a>
        <a href="mailto:<?= htmlspecialchars($footerEmail) ?>"><?= htmlspecialchars($footerEmail) ?></a>
      </div>

    </div>

    <div class="site-footer__bottom caption">
      &copy; <?= date('Y') ?> <?= htmlspecialchars($footerBrand) ?>
    </div>

  </div>
</footer>