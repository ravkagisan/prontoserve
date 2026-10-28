<?php
$current_page = 'tentang-kami';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>jtinova - Demo Carousel</title>

    <link rel="stylesheet" href="../Style/style.css">

    <style>
    .demo-content-section {
        padding-top: var(--space-48);
        padding-bottom: var(--space-24);
    }
    </style>
</head>

<body>

    <?php include_once __DIR__ . '/../Components/navbar.php'; ?>

    <?php
    $carousel_slides = [
      [
        'id' => 1,
        'image' => '../Assets/images/dummy.jpg',
        'title' => "Inovasi Digital Terdepan\nBersama TEFA JTI",
        'description' => "Menghadirkan riset terapan, kolaborasi industri, dan talenta teknologi unggul untuk transformasi digital masa depan.",
        'buttons' => [
          ['text' => 'Jelajahi Layanan', 'link' => '#', 'variant' => 'primary'],
          ['text' => 'Hubungi Kami', 'link' => '#', 'variant' => 'secondary']
        ]
      ],
      [
        'id' => 2,
        'image' => '../Assets/images/ajasendiri.jpg',
        'title' => "Pelatihan Profesional &\nSertifikasi Kompetensi",
        'description' => "Kurikulum berbasis industri terkini yang membekali peserta dengan skill praktis siap kerja di era teknologi modern.",
        'buttons' => [
          ['text' => 'Daftar Pelatihan', 'link' => '#', 'variant' => 'primary'],
          ['text' => 'Lihat Silabus', 'link' => '#', 'variant' => 'secondary']
        ]
      ]
    ];
    include __DIR__ . '/../Components/carousel.php';
    
    
  ?>
<?php include_once __DIR__ . '/../Components/footer.php'; ?>


</body>

</html>