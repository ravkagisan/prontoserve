<?php
include_once __DIR__ . '/button.php';

$carousel_type = $carousel_type ?? 'hero';
$carousel_id = 'carousel_' . substr(md5(uniqid((string)mt_rand(), true)), 0, 8);
$auto_slide_interval = $auto_slide_interval ?? 7000;

$asset_base = '';
if (file_exists('Assets/images/dummy.jpg')) {
    $asset_base = 'Assets/images/';
} elseif (file_exists('../Assets/images/dummy.jpg')) {
    $asset_base = '../Assets/images/';
} elseif (file_exists('../../Assets/images/dummy.jpg')) {
    $asset_base = '../../Assets/images/';
} else {
    $asset_base = 'Assets/images/';
}

if (!isset($carousel_slides) || !is_array($carousel_slides) || empty($carousel_slides)) {
    $carousel_slides = [
        [
            'id' => 1,
            'image' => $asset_base . 'dummy.jpg',
            'title' => "Inovasi Teknologi Terdepan\nBersama TEFA JTI Innovation",
            'description' => "Menghadirkan riset terapan dan transformasi digital melalui pengembangan perangkat lunak, sistem cerdas, dan solusi industri terpercaya.",
            'buttons' => [
                ['text' => 'Jelajahi Pelayanan', 'link' => 'Pages/Pelayanan/index.php', 'variant' => 'primary'],
                ['text' => 'Hubungi Kami', 'link' => 'Pages/HubungiKami/index.php', 'variant' => 'outline-white']
            ]
        ],
        [
            'id' => 2,
            'image' => $asset_base . 'ajasendiri.jpg',
            'title' => "Program Pelatihan Digital\nBerstandar Industri Terkini",
            'description' => "Tingkatkan keahlian teknis dan kompetensi profesional mahasiswa serta talenta digital melalui kurikulum praktis dan sertifikasi industri.",
            'buttons' => [
                ['text' => 'Lihat Pelatihan', 'link' => 'Pages/Pelatihan/index.php', 'variant' => 'primary'],
                ['text' => 'Lihat Portofolio', 'link' => 'Pages/Portofolio/index.php', 'variant' => 'outline-white']
            ]
        ]
    ];
}

foreach ($carousel_slides as &$slide) {
    if (!empty($slide['image']) && !filter_var($slide['image'], FILTER_VALIDATE_URL) && !file_exists($slide['image'])) {
        if (file_exists($asset_base . $slide['image'])) {
            $slide['image'] = $asset_base . $slide['image'];
        }
    }
}
unset($slide);
?>

<style>
  @keyframes zoomRight {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
  }

  .carousel-wrapper {
    position: relative;
    width: 100%;
    height: 480px;
    overflow: hidden;
    background-color: #000000;
  }

  @media (min-width: 768px) {
    .carousel-wrapper {
      height: 520px;
    }
  }

  @media (min-width: 1200px) {
    .carousel-wrapper {
      height: 560px;
    }
  }

  .carousel-slide {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    visibility: hidden;
    z-index: 1;
    pointer-events: none;
    transition: opacity 1s ease-in-out, visibility 1s ease-in-out;
  }

  .carousel-slide.active {
    opacity: 1;
    visibility: visible;
    z-index: 2;
    pointer-events: auto;
  }

  .carousel-bg-wrap {
    position: absolute;
    inset: 0;
    overflow: hidden;
  }

  .carousel-bg {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    opacity: 0.8;
    will-change: transform;
  }

  .carousel-slide.active .carousel-bg {
    animation: zoomRight 30s ease-out infinite;
    transform-origin: right center;
  }

  .carousel-overlay {
    position: absolute;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.4);
  }

  .carousel-content-wrap {
    position: relative;
    z-index: 3;
    height: 100%;
    display: flex;
    align-items: center;
    max-width: var(--container-max-width, 1200px);
    margin: 0 auto;
    padding: 0 var(--container-padding-x, 120px);
    box-sizing: border-box;
    width: 100%;
  }

  @media (max-width: 900px) {
    .carousel-content-wrap {
      padding: 0 var(--space-24, 24px);
    }
  }

  @media (max-width: 480px) {
    .carousel-content-wrap {
      padding: 0 var(--space-16, 16px);
    }
  }

  .carousel-text-box {
    max-width: 780px;
    color: var(--bg-white, #ffffff);
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.7s ease 0.2s, transform 0.7s ease 0.2s;
  }

  .carousel-slide.active .carousel-text-box {
    opacity: 1;
    transform: translateY(0);
  }

  .carousel-title {
    font-size: clamp(26px, 4.5vw, 48px);
    font-weight: 700;
    line-height: 1.25;
    margin: 0 0 var(--space-16, 16px) 0;
    color: var(--bg-white, #ffffff);
    white-space: pre-line;
    letter-spacing: -0.5px;
  }

  .carousel-desc {
    font-size: clamp(14px, 1.8vw, 18px);
    line-height: 1.6;
    margin: 0;
    color: rgba(255, 255, 255, 0.9);
    max-width: 660px;
    min-height: 52px;
  }

  .carousel-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: var(--space-16, 16px);
    align-items: center;
    margin-top: 32px;
  }

  @media (max-width: 768px) {
    .carousel-desc {
      min-height: auto;
    }
    .carousel-buttons {
      margin-top: 24px;
      gap: var(--space-8, 8px);
    }
  }

  .carousel-dots {
    position: absolute;
    bottom: var(--space-24, 24px);
    left: 50%;
    transform: translateX(-50%);
    z-index: 10;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .carousel-dot {
    width: 10px;
    height: 10px;
    border-radius: var(--radius-pill, 999px);
    background-color: rgba(255, 255, 255, 0.45);
    border: none;
    padding: 0;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .carousel-dot:hover {
    background-color: var(--bg-white, #ffffff);
  }

  .carousel-dot.active {
    width: 32px;
    background-color: var(--brand-teal, #8DBCC2);
  }

  .cards-carousel-section {
    width: 100%;
    max-width: var(--container-max-width, 1200px);
    margin: 0 auto;
    padding: var(--space-48, 48px) var(--container-padding-x, 120px);
    box-sizing: border-box;
    position: relative;
  }

  @media (max-width: 900px) {
    .cards-carousel-section {
      padding: var(--space-24, 24px);
    }
  }

  .cards-carousel-header {
    margin-bottom: var(--space-24, 24px);
  }

  .cards-carousel-h1 {
    font-size: clamp(24px, 3.5vw, 36px);
    font-weight: 700;
    color: var(--brand-primary, #1E3A5F);
    margin: 0 0 var(--space-8, 8px) 0;
  }

  .cards-carousel-h2 {
    font-size: 16px;
    color: var(--text-secondary, #6B7280);
    margin: 0;
  }

  .cards-carousel-wrap {
    position: relative;
  }

  .cards-scroll-container {
    display: flex;
    gap: var(--space-24, 24px);
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    padding-bottom: var(--space-16, 16px);
    scrollbar-width: none;
    -ms-overflow-style: none;
  }

  .cards-scroll-container::-webkit-scrollbar {
    display: none;
  }

  .card-item-link {
    text-decoration: none;
    color: inherit;
    flex: 0 0 380px;
    max-width: 85vw;
    scroll-snap-align: start;
  }

  .carousel-card-box {
    display: flex;
    height: 150px;
    background-color: var(--bg-white, #ffffff);
    border-radius: var(--radius-card, 16px);
    border: 1px solid var(--border-default, #D1D5E0);
    overflow: hidden;
    box-shadow: var(--shadow-card, 0 4px 16px rgba(0, 0, 0, 0.08));
    transition: transform 0.25s ease, box-shadow 0.25s ease;
  }

  .carousel-card-box:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
  }

  .carousel-card-img-wrap {
    width: 40%;
    position: relative;
    overflow: hidden;
    background-color: var(--bg-soft, #EBF1F5);
  }

  .carousel-card-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
  }

  .carousel-card-box:hover .carousel-card-img {
    transform: scale(1.06);
  }

  .carousel-card-body {
    width: 60%;
    padding: var(--space-16, 16px);
    display: flex;
    flex-direction: column;
    justify-content: center;
    box-sizing: border-box;
  }

  .carousel-card-title {
    font-size: 16px;
    font-weight: 700;
    color: var(--text-primary, #1F2937);
    margin: 0 0 var(--space-8, 8px) 0;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .carousel-card-desc {
    font-size: 13px;
    color: var(--text-secondary, #6B7280);
    margin: 0;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
</style>

<?php if ($carousel_type === 'cards'): ?>
  <?php
    $cards_h1 = $cards_h1 ?? 'Portofolio Terpilih';
    $cards_h2 = $cards_h2 ?? 'Jelajahi inovasi dan produk yang telah kami kembangkan bersama mitra industri.';
    $cards_data = $cards_data ?? [
        [
            'id' => 1,
            'title' => 'Sistem Informasi Manajemen Terintegrasi',
            'desc' => 'Platform digital enterprise untuk otomatisasi operasional dan pelaporan terpadu.',
            'img' => $asset_base . 'dummy.jpg',
            'link' => 'Pages/Portofolio/index.php'
        ],
        [
            'id' => 2,
            'title' => 'Aplikasi Pembelajaran Interaktif EduTech',
            'desc' => 'Media pembelajaran digital dengan fitur interaktif untuk meningkatkan kualitas edukasi.',
            'img' => $asset_base . 'ajasendiri.jpg',
            'link' => 'Pages/Portofolio/index.php'
        ],
        [
            'id' => 3,
            'title' => 'Implementasi IoT Smart Monitoring',
            'desc' => 'Sensor jaringan cerdas dan dashboard analitik data real-time berbasis cloud.',
            'img' => $asset_base . 'dummy.jpg',
            'link' => 'Pages/Portofolio/index.php'
        ]
    ];
  ?>
  <section class="cards-carousel-section" id="<?= htmlspecialchars($carousel_id) ?>">
    <div class="cards-carousel-header">
      <h2 class="cards-carousel-h1"><?= htmlspecialchars($cards_h1) ?></h2>
      <p class="cards-carousel-h2"><?= htmlspecialchars($cards_h2) ?></p>
    </div>

    <div class="cards-carousel-wrap">
      <div class="cards-scroll-container">
        <?php foreach ($cards_data as $card): ?>
          <a href="<?= htmlspecialchars($card['link'] ?? '#') ?>" class="card-item-link">
            <div class="carousel-card-box">
              <div class="carousel-card-img-wrap">
                <img src="<?= htmlspecialchars($card['img']) ?>" alt="<?= htmlspecialchars($card['title']) ?>" class="carousel-card-img">
              </div>
              <div class="carousel-card-body">
                <h3 class="carousel-card-title"><?= htmlspecialchars($card['title']) ?></h3>
                <p class="carousel-card-desc"><?= htmlspecialchars($card['desc']) ?></p>
              </div>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

<?php else: ?>
  <div class="carousel-wrapper" id="<?= htmlspecialchars($carousel_id) ?>">
    <?php foreach ($carousel_slides as $index => $slide): ?>
      <?php
        $is_active = ($index === 0);
        $buttons = [];
        if (!empty($slide['buttons']) && is_array($slide['buttons'])) {
            $buttons = $slide['buttons'];
        } elseif (!empty($slide['ctaText']) && !empty($slide['ctaLink'])) {
            $buttons = [['text' => $slide['ctaText'], 'link' => $slide['ctaLink'], 'variant' => 'outline-white']];
        }
      ?>
      <div class="carousel-slide <?= $is_active ? 'active' : '' ?>" data-index="<?= $index ?>">
        <div class="carousel-bg-wrap">
          <div class="carousel-bg" style="background-image: url('<?= htmlspecialchars($slide['image']) ?>');"></div>
          <div class="carousel-overlay"></div>
        </div>

        <div class="carousel-content-wrap">
          <div class="carousel-text-box">
            <h2 class="carousel-title"><?= htmlspecialchars($slide['title']) ?></h2>
            <?php if (!empty($slide['description'])): ?>
              <p class="carousel-desc"><?= htmlspecialchars($slide['description']) ?></p>
            <?php endif; ?>

            <?php if (!empty($buttons)): ?>
              <div class="carousel-buttons">
                <?php foreach ($buttons as $btn): ?>
                  <?php
                    $btn_variant = $btn['variant'] ?? 'primary';
                    if ($btn_variant === 'secondary' || $btn_variant === 'outline') {
                        $btn_variant = 'outline-white';
                    }
                    $btn_href = $btn['link'] ?? ($btn['href'] ?? null);
                    echo render_button([
                        'variant'       => $btn_variant,
                        'text'          => $btn['text'] ?? '',
                        'href'          => $btn_href,
                        'size'          => $btn['size'] ?? 'md',
                        'icon'          => $btn['icon'] ?? null,
                        'icon_position' => $btn['icon_position'] ?? 'right',
                        'class'         => $btn['class'] ?? ''
                    ]);
                  ?>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>

    <?php if (count($carousel_slides) > 1): ?>
      <div class="carousel-dots">
        <?php foreach ($carousel_slides as $index => $slide): ?>
          <button type="button" 
                  class="carousel-dot <?= ($index === 0) ? 'active' : '' ?>" 
                  data-target="<?= $index ?>" 
                  aria-label="Menuju slide <?= $index + 1 ?>">
          </button>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

  <script>
    (function() {
      const root = document.getElementById('<?= $carousel_id ?>');
      if (!root) return;

      const slides = root.querySelectorAll('.carousel-slide');
      const dots = root.querySelectorAll('.carousel-dot');
      const totalSlides = slides.length;
      const intervalDuration = <?= (int)$auto_slide_interval ?>;

      if (totalSlides <= 1) return;

      let current = 0;
      let timer = null;
      let isPaused = false;

      function goTo(index) {
        if (index < 0) {
          current = totalSlides - 1;
        } else if (index >= totalSlides) {
          current = 0;
        } else {
          current = index;
        }

        slides.forEach((slide, idx) => {
          slide.classList.toggle('active', idx === current);
        });

        dots.forEach((dot, idx) => {
          dot.classList.toggle('active', idx === current);
        });
      }

      function next() {
        goTo(current + 1);
      }

      function prev() {
        goTo(current - 1);
      }

      function startTimer() {
        stopTimer();
        timer = setInterval(() => {
          if (!isPaused) {
            next();
          }
        }, intervalDuration);
      }

      function stopTimer() {
        if (timer) {
          clearInterval(timer);
          timer = null;
        }
      }

      dots.forEach((dot) => {
        dot.addEventListener('click', () => {
          const target = parseInt(dot.getAttribute('data-target'), 10);
          goTo(target);
          startTimer();
        });
      });

      root.addEventListener('mouseenter', () => {
        isPaused = true;
      });

      root.addEventListener('mouseleave', () => {
        isPaused = false;
      });

      let touchStartX = 0;
      let touchEndX = 0;

      root.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
      }, { passive: true });

      root.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        const diff = touchStartX - touchEndX;
        if (Math.abs(diff) > 40) {
          if (diff > 0) {
            next();
          } else {
            prev();
          }
          startTimer();
        }
      }, { passive: true });

      startTimer();
    })();
  </script>
<?php endif; ?>
