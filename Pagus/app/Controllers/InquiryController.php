<?php

namespace App\Controllers;

use App\Libraries\SlackInquiryNotifier;
use App\Services\InquiryService;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RedirectResponse;
use InvalidArgumentException;

final class InquiryController extends Controller
{
    private InquiryService $inquiries;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger): void
    {
        parent::initController($request, $response, $logger);
        $this->inquiries = new InquiryService();
    }

    public function create(): RedirectResponse
    {
        $rules = ['name' => 'required|max_length[100]', 'contact' => 'permit_empty|max_length[255]', 'message' => 'required|max_length[2000]'];
        if (! $this->validate($rules)) {
            return redirect()->to('/#contact')->withInput()->with('error', '이름과 문의 내용을 확인하세요.');
        }
        try {
            $post = $this->request->getPost();
            $inquiryId = $this->inquiries->submit($post);
            // 운영 채널 Slack 알림 (실패해도 접수에는 영향 없음)
            SlackInquiryNotifier::fromEnv('Pagus')->notify($inquiryId, [
                '이름' => trim((string) ($post['name'] ?? '')),
                '연락처' => trim((string) ($post['contact'] ?? '')),
                '접수 시각' => date('Y-m-d H:i:s'),
                '요청 IP' => $this->request->getIPAddress(),
            ], trim((string) ($post['message'] ?? '')), base_url('admin/inquiries/' . $inquiryId));
        } catch (InvalidArgumentException $exception) {
            return redirect()->to('/#contact')->withInput()->with('error', $exception->getMessage());
        }
        return redirect()->to('/#contact')->with('message', '문의가 접수되었습니다.');
    }
}
