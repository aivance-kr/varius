<?php

declare(strict_types=1);

/**
 * 랜딩 화면 — 로그인 여부와 무관하게 '/'에서 항상 렌더된다.
 * 로그인 사용자에게는 상단 메뉴를 보여주고, 로그인 CTA 대신 업로드 화면으로 가는 버튼을 보여준다.
 *
 * @var int|null $userId    로그인 사용자 id(비로그인 시 null)
 * @var string   $pageTitle
 * @var string   $description
 * @var string   $canonicalUrl
 * @var string   $imageUrl
 * @var string   $jsonLd      JSON-LD 구조화 데이터(json_encode 결과, 스크립트 안전 플래그 적용)
 * @var list<array{q: string, a: string}> $faq
 * @var string   $loginUrl
 * @var string   $uploadUrl
 * @var string   $mapUrl
 * @var string   $tripsUrl
 * @var string   $logoutUrl
 */
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= esc($description, 'attr') ?>">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <link rel="canonical" href="<?= esc($canonicalUrl, 'attr') ?>">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="ko_KR">
    <meta property="og:site_name" content="Iter">
    <meta property="og:title" content="<?= esc($pageTitle, 'attr') ?>">
    <meta property="og:description" content="<?= esc($description, 'attr') ?>">
    <meta property="og:url" content="<?= esc($canonicalUrl, 'attr') ?>">
    <meta property="og:image" content="<?= esc($imageUrl, 'attr') ?>">
    <meta property="og:image:alt" content="Iter 로고">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="<?= esc($pageTitle, 'attr') ?>">
    <meta name="twitter:description" content="<?= esc($description, 'attr') ?>">
    <meta name="twitter:image" content="<?= esc($imageUrl, 'attr') ?>">
    <title><?= esc($pageTitle) ?></title>
    <script type="application/ld+json"><?= $jsonLd ?></script>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/apple-touch-icon.png">
    <link rel="stylesheet" href="/assets/nav.css">
    <style>
        html, body { margin: 0; font-family: system-ui, sans-serif; color: #222; }
        main { padding: 40px 20px; max-width: 480px; margin: 0 auto; text-align: center; }
        .btn {
            display: inline-block; padding: 10px 20px; border-radius: 8px; border: 1.5px solid transparent;
            background: #1a73e8; color: #fff; font-size: 15px; font-weight: 600; cursor: pointer;
            text-decoration: none; text-align: center; transition: background .15s, border-color .15s;
        }
        .btn:hover { background: #1558b0; }
        .legal-footer { margin-top: 24px; font-size: 13px; }
        .legal-footer a { color: #777; }
        .sr-only {
            position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px;
            overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0;
        }

        main.landing { max-width: 720px; padding: 32px 20px 56px; }
        .hero { text-align: center; padding-bottom: 8px; }
        .landing .logo { height: 40px; margin-bottom: 20px; }
        .landing .lead { font-size: 22px; font-weight: 700; line-height: 1.4; color: #222; margin: 0 0 12px; }
        .landing .sub { font-size: 15px; color: #666; line-height: 1.6; max-width: 520px; margin: 0 auto 24px; }
        .landing .btn { padding: 12px 28px; font-size: 16px; }
        .privacy-note {
            max-width: 520px; margin: 20px auto 0; padding: 12px 16px; border-radius: 10px;
            background: #eef4ff; color: #3a5a9c; font-size: 13px; line-height: 1.6;
        }
        .landing section { margin-top: 56px; text-align: left; }
        .landing h2 { font-size: 20px; margin: 0 0 16px; }
        .landing section p { font-size: 15px; color: #444; line-height: 1.75; margin: 0; }
        .steps { list-style: none; margin: 0; padding: 0; display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
        .steps li { background: #f7f8fa; border-radius: 10px; padding: 16px; }
        .steps .num {
            display: inline-flex; align-items: center; justify-content: center;
            width: 22px; height: 22px; border-radius: 50%;
            background: #1a73e8; color: #fff; font-size: 12px; font-weight: 700; margin-bottom: 8px;
        }
        .steps .title { font-size: 14px; font-weight: 600; margin-bottom: 4px; }
        .steps .desc { font-size: 13px; color: #666; line-height: 1.5; }
        .features { list-style: none; margin: 0; padding: 0; display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }
        .features li { background: #f7f8fa; border-radius: 10px; padding: 16px; font-size: 13px; color: #555; line-height: 1.6; }
        .features strong { display: block; font-size: 14px; color: #222; margin-bottom: 4px; }
        .faq details { border-bottom: 1px solid #e5e7eb; padding: 14px 0; }
        .faq details:first-of-type { border-top: 1px solid #e5e7eb; }
        .faq summary { cursor: pointer; font-weight: 600; font-size: 15px; }
        .faq details p { margin-top: 8px; font-size: 14px; }
        .legal-footer { margin-top: 56px; text-align: center; }
        @media (max-width: 520px) {
            .steps, .features { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<?php if ($userId !== null): ?>
    <?= view('partials/nav', ['uploadUrl' => $uploadUrl, 'mapUrl' => $mapUrl, 'tripsUrl' => $tripsUrl, 'logoutUrl' => $logoutUrl]) ?>
<?php endif; ?>
    <main class="landing">
        <header class="hero">
            <img class="logo" src="/assets/logo-wordmark.png" alt="Iter">
            <h1 class="sr-only">Iter — 사진 GPS로 그리는 여행 동선 지도</h1>
            <p class="lead">내가 찍은 사진 속 GPS로, 여행의 동선을 지도 위에 그려드립니다.</p>
            <p class="sub">Google Takeout에서 내보낸 사진 zip을 업로드하면, 언제 어디를 다녀왔는지 날짜별 경로로 한눈에 확인할 수 있어요.</p>
            <?php if ($userId !== null): ?>
                <a class="btn" href="<?= esc($uploadUrl, 'attr') ?>">사진 가져오기</a>
            <?php else: ?>
                <a class="btn" href="<?= esc($loginUrl, 'attr') ?>">Google로 로그인</a>
            <?php endif; ?>
            <p class="privacy-note">
                업로드된 zip은 위치·시각 정보 추출이 끝나는 즉시 서버에서 삭제됩니다.
                원본 사진 파일은 저장하지 않습니다.
            </p>
        </header>

        <section>
            <h2>이용 방법</h2>
            <ol class="steps">
                <li>
                    <span class="num">1</span>
                    <div class="title">Takeout 내보내기</div>
                    <div class="desc">Google 계정에서 사진(Google Photos)만 선택해 zip으로 내보냅니다.</div>
                </li>
                <li>
                    <span class="num">2</span>
                    <div class="title">zip 업로드</div>
                    <div class="desc">받은 zip 파일을 그대로 업로드하면 위치·시간을 자동으로 읽어옵니다.</div>
                </li>
                <li>
                    <span class="num">3</span>
                    <div class="title">동선 확인</div>
                    <div class="desc">날짜별 색으로 구분된 마커와 경로선으로 지도 위에서 동선을 확인합니다.</div>
                </li>
            </ol>
        </section>

        <section>
            <h2>Iter는 어떤 서비스인가요?</h2>
            <p>
                Iter(라틴어로 &lsquo;여정·경로&rsquo;)는 사진에 담긴 위치(GPS)와 촬영 시각을 읽어, 언제 어디를 다녀왔는지를
                날짜별 이동 동선으로 지도 위에 그려주는 무료 웹 서비스입니다. Google Photos는 보안 정책상 API로 내려받는 원본에서
                위치 정보를 제거하기 때문에, Iter는 Google Takeout으로 직접 내보낸 사진 zip(JSON 사이드카의 geoData)이나
                위치 정보가 남아 있는 일반 사진(EXIF) 압축파일, Google 지도 타임라인(위치기록) 파일에서 좌표를 추출합니다.
            </p>
        </section>

        <section>
            <h2>주요 기능</h2>
            <ul class="features">
                <li><strong>날짜별 동선 지도</strong>촬영 시각 순으로 마커와 경로선을 잇고, 날짜마다 다른 색으로 구분합니다. 지도는 OpenStreetMap 기반입니다.</li>
                <li><strong>여행 자동 그룹핑</strong>흩어진 사진을 여행 단위로 묶어 일정·방문 지역·통계를 한눈에 확인합니다.</li>
                <li><strong>시간대별 여행 스케줄</strong>하루의 이동을 시간 순서로 보고, 날짜와 시간대별 메모를 남길 수 있습니다.</li>
                <li><strong>발자국 지도</strong>방문한 국가와 시·도를 지도에 칠해 나의 여행 발자국을 확인합니다.</li>
                <li><strong>SNS 공유 링크</strong>하루 일정이나 여행 전체를 로그인 없이 볼 수 있는 링크로 공유합니다.</li>
                <li><strong>동선 재생</strong>썸네일 미리보기와 함께 이동 경로를 순서대로 재생해 여행을 되짚어봅니다.</li>
            </ul>
        </section>

        <section class="faq">
            <h2>자주 묻는 질문</h2>
<?php foreach ($faq as $item): ?>
            <details>
                <summary><?= esc($item['q']) ?></summary>
                <p><?= esc($item['a']) ?></p>
            </details>
<?php endforeach; ?>
        </section>

        <?php if ($userId === null): ?>
            <p class="legal-footer">
                <a href="/privacy-policy.html">개인정보처리방침</a> ·
                <a href="/terms-of-service.html">서비스 이용약관</a>
            </p>
        <?php endif; ?>
    </main>
</body>
</html>
