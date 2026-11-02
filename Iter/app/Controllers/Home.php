<?php

declare(strict_types=1);

namespace App\Controllers;

/**
 * 랜딩 페이지 — 로그인 여부와 무관하게 항상 렌더된다(GET /).
 * 로그인 사용자에게는 상단 메뉴와 "사진 가져오기" 버튼을 보여주고, 로그인 CTA는 숨긴다.
 * 업로드 폼 자체는 GET /upload(TakeoutController::form)에서 별도로 제공한다.
 */
class Home extends BaseController
{
    private const TITLE = 'Iter — 사진 GPS로 그리는 여행 동선 지도';

    private const DESCRIPTION = '구글 포토 Takeout 사진 zip을 업로드하면 사진 속 GPS와 촬영 시각으로 날짜별 여행 동선을 지도 위에 그려주는 무료 서비스. 여행 자동 그룹핑, 시간대별 스케줄, 발자국 지도, SNS 공유 링크를 제공합니다.';

    /** @var list<array{q: string, a: string}> */
    private const FAQ = [
        [
            'q' => 'Iter는 무엇인가요?',
            'a' => 'Iter는 사진에 담긴 GPS 위치와 촬영 시각을 읽어 날짜별 이동 동선을 지도 위에 마커와 경로선으로 시각화하는 웹 서비스입니다.',
        ],
        [
            'q' => '구글 포토에서 바로 불러올 수 없나요?',
            'a' => 'Google Photos API는 다운로드 원본에서 위치 정보를 의도적으로 제거합니다. 그래서 위치가 보존되는 Google Takeout 내보내기 zip을 직접 업로드하는 방식을 사용합니다.',
        ],
        [
            'q' => 'Google Takeout zip은 어떻게 만드나요?',
            'a' => 'takeout.google.com에서 Google Photos만 선택해 내보내면 사진과 함께 위치가 담긴 JSON 파일이 zip으로 만들어집니다. 받은 zip을 그대로 업로드하면 됩니다.',
        ],
        [
            'q' => '원본 사진은 서버에 저장되나요?',
            'a' => '저장하지 않습니다. 업로드한 zip과 압축 해제한 원본은 위치·시각 추출이 끝나는 즉시 삭제되고, 지도 미리보기용 가로 300px 썸네일만 보관합니다. 계정 데이터는 언제든 삭제할 수 있습니다.',
        ],
        [
            'q' => 'Takeout이 아닌 사진이나 위치기록도 쓸 수 있나요?',
            'a' => '위치 정보(EXIF)가 남아 있는 일반 사진 압축파일과 Google 지도 타임라인(위치기록) 파일도 업로드할 수 있습니다.',
        ],
        [
            'q' => '비용이 드나요?',
            'a' => '무료로 이용할 수 있으며 Google 계정으로 로그인해 사용합니다. 로그인에는 이메일·프로필 정보만 쓰고 Google Photos 라이브러리에는 접근하지 않습니다.',
        ],
    ];

    public function index(): string
    {
        helper('url');

        $canonicalUrl = base_url('/');
        $imageUrl = base_url('assets/logo-mark-512.png');

        return view('landing', [
            'userId' => $this->currentUserId(),
            'loginUrl' => site_url('auth/google'),
            'uploadUrl' => site_url('upload'),
            'mapUrl' => site_url('map'),
            'tripsUrl' => site_url('trips'),
            'logoutUrl' => site_url('auth/logout'),
            'pageTitle' => self::TITLE,
            'description' => self::DESCRIPTION,
            'canonicalUrl' => $canonicalUrl,
            'imageUrl' => $imageUrl,
            'faq' => self::FAQ,
            'jsonLd' => $this->jsonLd($canonicalUrl, $imageUrl),
        ]);
    }

    /** schema.org 구조화 데이터(WebSite·WebApplication·FAQPage). 스크립트 태그 탈출 방지 플래그를 적용한다. */
    private function jsonLd(string $url, string $imageUrl): string
    {
        $graph = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'WebSite',
                    '@id' => $url . '#website',
                    'name' => 'Iter',
                    'url' => $url,
                    'inLanguage' => 'ko-KR',
                ],
                [
                    '@type' => 'WebApplication',
                    '@id' => $url . '#app',
                    'name' => 'Iter',
                    'url' => $url,
                    'image' => $imageUrl,
                    'description' => self::DESCRIPTION,
                    'applicationCategory' => 'TravelApplication',
                    'operatingSystem' => 'Web',
                    'inLanguage' => 'ko-KR',
                    'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'KRW'],
                    'featureList' => [
                        '날짜별 이동 동선 지도',
                        '여행 자동 그룹핑',
                        '시간대별 여행 스케줄',
                        '방문 국가·시도 발자국 지도',
                        'SNS 공유 링크',
                    ],
                ],
                [
                    '@type' => 'FAQPage',
                    'mainEntity' => array_map(static fn (array $f): array => [
                        '@type' => 'Question',
                        'name' => $f['q'],
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
                    ], self::FAQ),
                ],
            ],
        ];

        return json_encode($graph, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_THROW_ON_ERROR);
    }
}
