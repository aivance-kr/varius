# Product

<!-- impeccable:product-schema 1 -->

## Platform

web

## Users
여행 기록 애호가. 여행마다 사진으로 동선·일정·메모를 꼼꼼히 남기고 되돌아보며, 필요하면 SNS 링크로 공유하는 한국어 사용자. 별도 기록 앱 없이 이미 찍어둔 사진으로 과거 여행을 복원하려는 상황이다. (주 사용자 확정, 그 외 청중은 미확정)

## Product Purpose
사용자가 Google Takeout으로 내보낸 사진 zip(또는 위치 정보가 남은 일반 사진 압축파일, Google 지도 타임라인 파일)을 업로드하면 GPS와 촬영 시각을 추출해 날짜별 이동 동선을 지도 위에 마커·경로선으로 시각화한다. 프로젝트명 Iter는 라틴어로 '여정·경로'. 성공은 업로드 한 번으로 과거 여행의 동선과 일정이 복원되고 공유까지 이어지는 것.

## Positioning
별도 기록 앱이나 사전 설정 없이, 이미 찍어둔 사진의 GPS만으로 과거 여행 동선을 복원한다. 경쟁 서비스(Google 타임라인, 일반 지도앱)는 사전 기록이 필요하거나 사진 기반 복원이 불가능하다.

## Operating Context
Google Photos API는 다운로드 원본에서 GPS를 의도적으로 제거하므로, 위치가 보존되는 Google Takeout zip 업로드가 유일한 경로다. 동기 처리, 200장 상한, 업로드 레이트 리밋 적용. Google OAuth는 사용자 식별용(openid·email·profile)만 사용하고 Photos 라이브러리에는 접근하지 않는다.

## Capabilities and Constraints
- 기능: 날짜별 동선 지도(Leaflet + OpenStreetMap), 여행 자동 그룹핑, 시간대별 스케줄·날짜/시간 메모, 발자국 지도(방문 국가·시도), 동선 재생·썸네일 미리보기, 비로그인 공개 열람 SNS 공유 링크(하루·여행 단위).
- 스택: PHP 8.2+ / CodeIgniter 4 / MySQL. 모노레포 내 `Iter/` 서브디렉토리, CI/CD 없이 로컬 검증.
- 개인정보: 업로드 zip·원본 사진은 추출 직후 삭제, 가로 300px 썸네일만 보관. 계정 데이터 삭제 기능 제공. 좌표 이상치(시속 200km 초과)는 필터링.
- 미정: 랜딩 로고 이미지(`logo-wordmark.png`)가 "PhotoTrail" 워드마크로 보임 — 서비스명 Iter와 불일치, 브랜딩 결정 필요.

## Brand Commitments
서비스명 Iter(라틴어 '여정·경로'). 한국어 우선 카피, 친근한 존댓말("~해요/~합니다"). 로고 자산은 `public/assets/`의 logo-mark-512.png, logo-wordmark.png (위 불일치 참고).

## Evidence on Hand
사용자 후기·고객사·벤치마크·가격 정보 없음 — 만들어내지 않는다. 실제 자산은 `public/assets/` 로고·파비콘, `public/assets/geo/`(국가·시도 경계 GeoJSON), 개인정보처리방침·이용약관 HTML뿐.

## Product Principles
1. 사진 한 번 업로드로 가치를 보여준다 — 사전 설정·기록 습관을 요구하지 않는다.
2. 프라이버시가 기본값이다 — 원본은 저장하지 않고, 저장하는 것(썸네일)과 삭제 방법을 숨기지 않는다.
3. 여행 단위로 사고한다 — 사진 목록이 아니라 날짜·동선·일정으로 정리한다.
4. 제약을 솔직히 설명한다 — Takeout 경유가 필요한 이유를 사용자가 납득하도록 안내한다.
5. 보는 사람 중심 공유 — 공유 링크는 로그인 없이 열리고 동선이 바로 읽힌다.
