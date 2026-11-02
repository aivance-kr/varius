<?php

declare(strict_types=1);

namespace App\Controllers;

/**
 * 검색엔진·생성형 AI 크롤러용 메타 문서 — robots.txt, sitemap.xml.
 * 절대 URL(baseURL)이 필요해 정적 파일이 아닌 라우트로 제공한다.
 */
class SeoController extends BaseController
{
    public function robots(): \CodeIgniter\HTTP\ResponseInterface
    {
        helper('url');

        $body = implode("\n", [
            'User-agent: *',
            'Allow: /',
            'Disallow: /auth/',
            'Disallow: /upload',
            'Disallow: /takeout/',
            'Disallow: /photos/',
            'Disallow: /account/',
            'Disallow: /routes',
            'Disallow: /map',
            'Disallow: /trips',
            'Disallow: /timeline/',
            'Disallow: /footprint',
            'Disallow: /thumbnails/',
            'Disallow: /s/',
            'Disallow: /t/',
            '',
            'Sitemap: ' . base_url('sitemap.xml'),
            '',
        ]);

        return $this->response->setContentType('text/plain; charset=UTF-8')->setBody($body);
    }

    public function sitemap(): \CodeIgniter\HTTP\ResponseInterface
    {
        helper('url');

        $urls = ['/', 'privacy-policy.html', 'terms-of-service.html'];
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n"
            . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as $path) {
            $xml .= '  <url><loc>' . esc(base_url($path), 'url') . "</loc></url>\n";
        }
        $xml .= '</urlset>' . "\n";

        return $this->response->setContentType('application/xml; charset=UTF-8')->setBody($xml);
    }
}
