---
name: Iter
description: 사진 GPS로 그리는 여행 동선 지도 — 여행 일지처럼 담백한 웹 UI
colors:
  route-blue: "#1a73e8"
  route-blue-deep: "#1558b0"
  ink: "#222222"
  body-gray: "#444444"
  muted-gray: "#777777"
  paper: "#ffffff"
  mist-surface: "#f7f8fa"
  hairline: "#e5e7eb"
  note-blue-bg: "#eef4ff"
  note-blue-text: "#3a5a9c"
  alert-red: "#c0392b"
  alert-red-bg: "#fdecea"
  ok-green-bg: "#eaf6ec"
typography:
  headline:
    fontFamily: "system-ui, sans-serif"
    fontSize: "22px"
    fontWeight: 700
    lineHeight: 1.4
  title:
    fontFamily: "system-ui, sans-serif"
    fontSize: "20px"
    fontWeight: 700
  body:
    fontFamily: "system-ui, sans-serif"
    fontSize: "15px"
    fontWeight: 400
    lineHeight: 1.75
  label:
    fontFamily: "system-ui, sans-serif"
    fontSize: "13px"
    fontWeight: 600
    lineHeight: 1.5
rounded:
  sm: "6px"
  md: "8px"
  lg: "10px"
  pill: "999px"
spacing:
  xs: "8px"
  sm: "12px"
  md: "16px"
  lg: "24px"
  xl: "56px"
components:
  button-primary:
    backgroundColor: "{colors.route-blue}"
    textColor: "{colors.paper}"
    typography: "{typography.label}"
    rounded: "{rounded.md}"
    padding: "12px 28px"
  button-primary-hover:
    backgroundColor: "{colors.route-blue-deep}"
  card-surface:
    backgroundColor: "{colors.mist-surface}"
    textColor: "{colors.body-gray}"
    rounded: "{rounded.lg}"
    padding: "16px"
  note-callout:
    backgroundColor: "{colors.note-blue-bg}"
    textColor: "{colors.note-blue-text}"
    rounded: "{rounded.lg}"
    padding: "12px 16px"
---

# Design System: Iter

## Overview

**Creative North Star: "The Travel Logbook"**

Iter는 여행 일지처럼 읽힌다. 흰 종이 위에 지도와 기록이 놓이고, UI는 그 기록을 방해하지 않는 담백한 여백과 단정한 정돈으로 물러난다. 화려한 장식 대신 시스템 폰트, 하나의 파랑 액센트, 옅은 회색 면만 쓴다. 주인공은 날짜별 색으로 그려지는 동선과 사용자가 남긴 메모이며, 인터페이스는 그 주변을 정리하는 역할이다.

밀도는 중간이다. 설명 문장은 충분히 풀어 쓰고(행간 1.75), 섹션 사이는 넓게 비워 호흡을 만든다. 톤은 친근하되 가볍지 않은 존댓말이다.

**Key Characteristics:**
- 흰 바탕 + 단일 파랑 액센트(`#1a73e8`), 시스템 폰트
- 평면 기본, 그림자는 거의 쓰지 않음
- 둥근 8~10px 모서리, 옅은 회색 면으로 그룹 구분
- 지도·동선 데이터가 시각적 주인공

## Colors

차분한 중립 위에 파랑 하나만 말하는 팔레트. 날짜별 동선 색은 지도 데이터 시각화 영역이며 UI 팔레트와 별개다.

### Primary
- **Route Blue** (#1a73e8): 주요 버튼, 단계 번호 배지, 링크성 강조. 화면당 소수 요소에만 쓴다.
- **Route Blue Deep** (#1558b0): Route Blue 버튼의 hover 상태.

### Neutral
- **Ink** (#222222): 제목·본문 기본 글자.
- **Body Gray** (#444444): 긴 설명 문단.
- **Muted Gray** (#777777 / #666666): 보조 설명, 법적 링크, 카드 안 설명.
- **Paper** (#ffffff): 페이지 바탕, 파란 버튼 위 글자.
- **Mist Surface** (#f7f8fa): 카드·단계·기능 블록 면.
- **Hairline** (#e5e7eb): FAQ 구분선 등 얇은 경계. 상단 메뉴 하단선은 `#ddd`.

### Status
- **Note Blue** (배경 #eef4ff / 글자 #3a5a9c): 개인정보 안내 같은 정보성 콜아웃.
- **Alert Red** (#c0392b, 배경 #fdecea): 오류 메시지.
- **OK Green** (배경 #eaf6ec): 성공 안내.

### Named Rules
**The One Voice Rule.** 파랑 액센트는 한 화면에서 행동을 부르는 요소(주요 버튼, 단계 번호)에만 쓴다. 장식에 쓰지 않는다.

## Typography

**Font:** `system-ui, sans-serif` 단일 스택. 별도 웹폰트를 불러오지 않는다.

**Character:** 운영체제 기본 글꼴이 주는 담백함과 한글 가독성. 위계는 굵기와 크기로만 만든다.

### Hierarchy
- **Headline** (700, 22px, 1.4): 랜딩 한 줄 소개.
- **Title** (700, 20px): 섹션 제목(h2).
- **Body** (400, 15px, 1.75): 서비스 설명·FAQ 답변. 한 줄은 컨테이너 폭(최대 720px)으로 제한.
- **Label** (600, 13~14px): 카드 제목, 버튼 글자, 보조 안내.

### Named Rules
**The One Family Rule.** 글꼴은 시스템 폰트 하나. 위계가 필요하면 크기·굵기를 바꾸고 폰트를 추가하지 않는다.

## Layout

중앙 단일 컬럼. 랜딩 컨테이너 최대 720px, 좌우 20px 여백. 맨 위 히어로(로고·한 줄 소개·CTA·안내)는 가운데 정렬, 그 아래 정보 섹션은 왼쪽 정렬로 읽는다. 섹션 사이 간격은 56px, 섹션 안 제목과 내용 사이는 16px, 카드 사이는 12px로 대비를 둔다. 3열(이용 방법)·2열(기능) 그리드는 520px 이하에서 1열로 접힌다. 지도 화면은 사이드 패널 + 지도 구조이며 별도 규칙을 따른다.

## Elevation & Depth

평면 기본(flat-by-default). 면의 구분은 Mist Surface 같은 톤 차이와 얇은 경계선으로 한다. 카드에 `0 1px 3px rgba(0,0,0,0.05)` 수준의 옅은 그림자를 쓰는 곳이 있으나 구분용 앰비언트일 뿐이다. 강한 그림자(`0 8px 40px rgba(0,0,0,.5)` 등)는 사진 미리보기 같은 오버레이에만 쓴다.

### Named Rules
**The Flat-By-Default Rule.** 평소 면은 평평하다. 깊이는 오버레이처럼 실제로 위에 떠 있는 요소에만 준다.

## Shapes

둥글고 단정하다. 버튼 8px, 카드·콜아웃·단계 블록 10px, 작은 컨트롤 6px, 단계 번호 배지는 원형(22px), 칩·태그는 pill(999px). 윤곽선보다 면(채움)으로 형태를 만든다.

## Components

친근하고 단정한 부품들. 설명이 충분하고 부드러운 톤.

### Buttons
- **Shape:** 8px 둥근 모서리
- **Primary:** Route Blue 채움 + 흰 글자, 12px 28px 패딩, 16px/600
- **Hover:** Route Blue Deep으로 150ms 전환
- **Focus:** 기본 포커스 링 유지(제거하지 않음)

### Cards / Containers
- **Corner Style:** 10px
- **Background:** Mist Surface(#f7f8fa)
- **Shadow Strategy:** 없음(평면)
- **Internal Padding:** 16px

### Callout
- **Style:** Note Blue 배경 + 글자, 10px 모서리, 12px 16px 패딩. 개인정보 안내처럼 안심시키는 보조 설명에 쓴다.

### Navigation
- 상단 가로 메뉴. 14px 링크, 색 #222, hover 시 밑줄. 하단 1px #ddd 선. 로고는 24px 높이, 로그인 사용자에게만 표시.

### FAQ (Signature)
- `details/summary` 접이식. 항목은 1px Hairline 구분선, 질문 15px/600, 답변 14px 본문색.

## Do's and Don'ts

### Do:
- **Do** 주요 행동 요소에만 Route Blue를 쓴다.
- **Do** 섹션 사이는 56px, 카드 사이는 12px로 대비 있는 리듬을 만든다.
- **Do** 그룹은 Mist Surface 면과 근접성으로 묶는다.
- **Do** 설명 글은 행간 1.75, 존댓말("~해요/~합니다").

### Don't:
- **Don't** 웹폰트나 두 번째 글꼴을 추가하지 않는다.
- **Don't** 평소 면에 그림자를 넣지 않는다 — 그림자는 오버레이 전용.
- **Don't** 파랑을 장식·배경 면으로 넓게 쓰지 않는다.
- **Don't** UI 팔레트와 지도 날짜별 동선 색을 섞지 않는다.
