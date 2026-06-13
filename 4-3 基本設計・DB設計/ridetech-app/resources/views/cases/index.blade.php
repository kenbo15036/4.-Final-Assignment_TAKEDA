<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>家電配送 現場向け情報共有システム - レイアウト試案</title>
  <style>
    /* ===== リセット & ベース ===== */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Hiragino Sans', 'Meiryo', sans-serif; background: #f0f2f5; color: #1a1a1a; font-size: 14px; }

    /* ===== 画面ナビゲーター（デモ用） ===== */
    #nav-bar {
      position: fixed; top: 0; left: 0; right: 0; z-index: 9999;
      background: #1a1a2e; color: #fff; padding: 8px 12px;
      display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
    }
    #nav-bar span { font-size: 11px; opacity: .6; margin-right: 4px; }
    #nav-bar button {
      background: #16213e; border: 1px solid #0f3460; color: #e0e0e0;
      padding: 4px 10px; border-radius: 4px; cursor: pointer; font-size: 11px;
    }
    #nav-bar button.active { background: #e94560; border-color: #e94560; color: #fff; }

    /* ===== 画面コンテナ ===== */
    .screens-wrapper { padding-top: 48px; }
    .screen { display: none; max-width: 430px; margin: 0 auto; min-height: 100vh; background: #fff; position: relative; }
    .screen.active { display: flex; flex-direction: column; }

    /* ===== 共通ヘッダー ===== */
    .app-header {
      background: #1976d2; color: #fff;
      display: flex; align-items: center; justify-content: space-between;
      padding: 12px 16px; position: sticky; top: 48px; z-index: 100;
    }
    .app-header h1 { font-size: 16px; font-weight: 700; }
    .app-header .back-btn {
      background: none; border: none; color: #fff; font-size: 18px; cursor: pointer; padding: 4px 8px;
    }
    .app-header .menu-btn {
      background: none; border: none; color: #fff; font-size: 20px; cursor: pointer;
    }

    /* ===== 共通ボトムナビ ===== */
    .bottom-nav {
      position: sticky; bottom: 0; background: #fff; border-top: 1px solid #ddd;
      display: flex; justify-content: space-around; padding: 8px 0;
    }
    .bottom-nav button {
      display: flex; flex-direction: column; align-items: center;
      background: none; border: none; cursor: pointer; color: #888; font-size: 10px; gap: 2px;
    }
    .bottom-nav button.active { color: #1976d2; }
    .bottom-nav .icon { font-size: 20px; }

    /* ===== コンテンツエリア ===== */
    .content { flex: 1; overflow-y: auto; padding: 16px; }

    /* ===== ボタン ===== */
    .btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px;
      padding: 10px 16px; border-radius: 8px; border: none; cursor: pointer; font-size: 14px; font-weight: 600; }
    .btn-primary { background: #1976d2; color: #fff; }
    .btn-danger  { background: #e53935; color: #fff; }
    .btn-outline { background: #fff; color: #1976d2; border: 1.5px solid #1976d2; }
    .btn-block   { display: flex; width: 100%; }
    .btn-sm      { padding: 6px 12px; font-size: 12px; }

    /* ===== フォーム ===== */
    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 12px; color: #666; margin-bottom: 4px; font-weight: 600; }
    .form-group input, .form-group select, .form-group textarea {
      width: 100%; padding: 10px 12px; border: 1.5px solid #ddd; border-radius: 8px;
      font-size: 14px; outline: none; transition: border-color .2s;
    }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: #1976d2; }
    .form-group textarea { resize: vertical; min-height: 80px; }

    /* ===== カード ===== */
    .card { background: #fff; border-radius: 12px; box-shadow: 0 1px 4px rgba(0,0,0,.1); margin-bottom: 12px; overflow: hidden; }
    .card-body { padding: 14px; }
    .card-header { padding: 12px 14px; background: #f5f5f5; border-bottom: 1px solid #eee; font-weight: 700; font-size: 13px; }

    /* ===== バッジ ===== */
    .badge { display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 11px; font-weight: 600; }
    .badge-blue   { background: #e3f2fd; color: #1565c0; }
    .badge-green  { background: #e8f5e9; color: #2e7d32; }
    .badge-red    { background: #ffebee; color: #c62828; }
    .badge-orange { background: #fff3e0; color: #e65100; }
    .badge-gray   { background: #f5f5f5; color: #616161; }

    /* ===== リスト ===== */
    .list-item {
      display: flex; align-items: flex-start; gap: 12px;
      padding: 14px 16px; border-bottom: 1px solid #f0f0f0; cursor: pointer;
    }
    .list-item:last-child { border-bottom: none; }
    .list-item:active { background: #f5f5f5; }
    .list-item-main { flex: 1; }
    .list-item-name { font-weight: 700; font-size: 15px; margin-bottom: 4px; }
    .list-item-sub  { font-size: 12px; color: #666; }
    .list-item-right { text-align: right; }

    /* ===== 区切り ===== */
    .divider { height: 8px; background: #f0f2f5; margin: 0 -16px; }

    /* ===== タブ ===== */
    .tabs { display: flex; border-bottom: 2px solid #eee; margin-bottom: 16px; }
    .tabs button {
      flex: 1; padding: 10px; background: none; border: none; cursor: pointer;
      font-size: 13px; color: #888; border-bottom: 2px solid transparent; margin-bottom: -2px;
    }
    .tabs button.active { color: #1976d2; border-bottom-color: #1976d2; font-weight: 700; }

    /* ===== その他 ===== */
    .row { display: flex; gap: 12px; }
    .row > * { flex: 1; }
    .text-center { text-align: center; }
    .text-sm { font-size: 12px; }
    .text-muted { color: #888; }
    .mt-8  { margin-top: 8px; }
    .mt-12 { margin-top: 12px; }
    .mt-16 { margin-top: 16px; }
    .mb-8  { margin-bottom: 8px; }
    .section-title { font-size: 13px; font-weight: 700; color: #555; margin-bottom: 10px; text-transform: uppercase; letter-spacing: .5px; }

    /* ===== アコーディオン ===== */
    .accordion-header {
      display: flex; align-items: center; justify-content: space-between;
      padding: 12px 14px; cursor: pointer; background: #fff3e0;
    }
    .accordion-body { padding: 14px; display: none; border-top: 1px solid #ffe0b2; }
    .accordion-body.open { display: block; }

    /* ===== 写真アップロードエリア ===== */
    .photo-upload {
      border: 2px dashed #bbb; border-radius: 8px; padding: 20px;
      text-align: center; color: #aaa; cursor: pointer; font-size: 13px;
    }
    .photo-thumbs { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 10px; }
    .photo-thumb { width: 70px; height: 70px; background: #e0e0e0; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 24px; }

    /* ===== FAB ===== */
    .fab {
      position: fixed; bottom: 72px; right: 20px;
      width: 52px; height: 52px; border-radius: 50%;
      background: #1976d2; color: #fff; font-size: 24px;
      border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(25,118,210,.4);
      display: flex; align-items: center; justify-content: center; z-index: 50;
    }

    /* ===== 地図プレースホルダー ===== */
    .map-placeholder {
      background: #cfe8d5; border-radius: 12px;
      height: 200px; display: flex; align-items: center; justify-content: center;
      flex-direction: column; gap: 8px; color: #2e7d32; font-size: 13px;
    }
    .map-placeholder .map-icon { font-size: 40px; }

    /* ===== ステータスライン ===== */
    .status-bar { height: 4px; background: #eee; border-radius: 2px; overflow: hidden; margin: 6px 0; }
    .status-bar-fill { height: 100%; background: #1976d2; border-radius: 2px; }

    /* ===== ログイン画面専用 ===== */
    #s001 { justify-content: center; background: linear-gradient(160deg, #1565c0 0%, #0d47a1 100%); }
    .login-logo { text-align: center; color: #fff; margin-bottom: 32px; }
    .login-logo .logo-icon { font-size: 56px; margin-bottom: 8px; }
    .login-logo h2 { font-size: 18px; font-weight: 700; }
    .login-logo p  { font-size: 12px; opacity: .7; margin-top: 4px; }
    .login-box { background: #fff; border-radius: 16px; padding: 24px; margin: 0 16px; box-shadow: 0 8px 24px rgba(0,0,0,.2); }

    /* ===== トップ画面専用 ===== */
    .top-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .top-tile {
      background: #fff; border-radius: 12px; box-shadow: 0 1px 4px rgba(0,0,0,.1);
      padding: 20px 14px; display: flex; flex-direction: column; align-items: center; gap: 8px;
      cursor: pointer; transition: transform .1s;
    }
    .top-tile:active { transform: scale(.97); }
    .top-tile .tile-icon { font-size: 36px; }
    .top-tile .tile-label { font-size: 13px; font-weight: 700; text-align: center; }
    .top-tile .tile-badge { font-size: 11px; background: #ffebee; color: #c62828; padding: 2px 8px; border-radius: 20px; }

    /* ===== 日付セレクタ ===== */
    .date-selector {
      display: flex; align-items: center; justify-content: space-between;
      background: #e3f2fd; border-radius: 10px; padding: 10px 14px; margin-bottom: 16px;
    }
    .date-selector button { background: none; border: none; font-size: 20px; cursor: pointer; color: #1976d2; }
    .date-selector .date-text { font-weight: 700; font-size: 15px; color: #0d47a1; }

    /* ===== 訪問順バッジ ===== */
    .order-badge {
      width: 30px; height: 30px; border-radius: 50%; background: #1976d2;
      color: #fff; font-weight: 700; font-size: 14px;
      display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }

    /* ===== チーム情報バー ===== */
    .team-bar {
      background: #e8eaf6; border-radius: 10px; padding: 10px 14px;
      margin-bottom: 14px; display: flex; gap: 16px; flex-wrap: wrap; align-items: center;
    }
    .team-bar .team-label { font-size: 12px; color: #5c6bc0; font-weight: 700; }
    .team-bar .team-members { display: flex; gap: 12px; flex-wrap: wrap; }
    .team-bar .member { display: flex; align-items: center; gap: 4px; font-size: 12px; }
    .team-bar .member .role { color: #888; }
    .team-bar .member .name { font-weight: 700; color: #1a1a1a; }

    /* ===== タブレット縦向き対応（768px以上） ===== */
    @media (min-width: 768px) {
      body { font-size: 15px; }

      .screens-wrapper { padding-top: 52px; }

      #nav-bar { padding: 10px 16px; }
      #nav-bar button { font-size: 11px; padding: 5px 10px; }

      /* タブレット縦向きは幅いっぱいに使う */
      .screen { max-width: 100%; }

      .app-header { top: 52px; padding: 14px 20px; }
      .app-header h1 { font-size: 17px; }

      .content { padding: 16px 20px; }

      /* トップ画面：縦向きは3列（4列は窮屈） */
      .top-grid { grid-template-columns: 1fr 1fr 1fr; }
      .top-tile { padding: 20px 14px; }
      .top-tile .tile-icon { font-size: 38px; }
      .top-tile .tile-label { font-size: 13px; }

      /* 案件一覧：テーブル表示（縦向き幅に最適化） */
      .case-table { display: table; width: 100%; border-collapse: collapse; }
      .case-table-head { display: table-header-group; }
      .case-table-head .case-row { background: #f5f7fa; }
      .case-table-body { display: table-row-group; }
      .case-row { display: table-row; }
      .case-row:hover { background: #f5f7ff; cursor: pointer; }
      .case-row:not(.case-table-head .case-row) { border-bottom: 1px solid #f0f0f0; }
      /* 縦向きタブレットは住所列を省略してスッキリさせる */
      .case-cell { display: table-cell; padding: 11px 10px; vertical-align: middle; font-size: 13px; }
      .case-cell.col-order  { width: 38px; text-align: center; }
      .case-cell.col-name   { width: 120px; font-weight: 700; font-size: 14px; }
      .case-cell.col-addr   { display: none; } /* 縦向きでは住所列を非表示 */
      .case-cell.col-item   { color: #444; font-size: 13px; }
      .case-cell.col-wish   { width: 100px; font-size: 12px; color: #555; white-space: nowrap; }
      .case-cell.col-plan   { width: 105px; font-size: 13px; font-weight: 700; color: #1565c0; white-space: nowrap; }
      .case-cell.col-status { width: 76px; text-align: center; }
      .case-table-head .case-cell { font-size: 11px; font-weight: 700; color: #888; letter-spacing: .4px; }
      /* 名前セルに住所を補足として入れる */
      .case-cell.col-name .sub-addr { font-size: 11px; color: #999; font-weight: 400; margin-top: 2px; }

      /* モバイル用リスト非表示 → テーブル表示 */
      .mobile-list { display: none; }
      .tablet-table { display: table !important; }

      /* フォームを2カラムに */
      .form-2col { display: grid; grid-template-columns: 1fr 1fr; gap: 0 16px; }

      /* ボトムナビ */
      .bottom-nav { gap: 24px; padding: 10px 0; }
      .bottom-nav button { font-size: 12px; }
      .bottom-nav .icon { font-size: 22px; }

      /* カードの余白 */
      .card-body { padding: 16px; }
      .card-header { padding: 13px 16px; }

      /* チームバー横並び */
      .team-bar { flex-direction: row; align-items: center; gap: 16px; }

      /* 日付セレクタ */
      .date-selector { padding: 11px 16px; margin-bottom: 16px; }
      .date-selector .date-text { font-size: 16px; }

      /* FAB */
      .fab { bottom: 76px; right: 24px; width: 54px; height: 54px; font-size: 26px; }

      /* 案件詳細グリッド */
      .detail-grid { grid-template-columns: 1fr 1fr 1fr; }
    }
  </style>
</head>
<body>

<!-- デモ用ナビゲーションバー -->
<div id="nav-bar">
  <span>画面切替：</span>
  <button onclick="show('s001')" id="btn-s001">S-001 ログイン</button>
  <button onclick="show('s002')" id="btn-s002">S-002 トップ</button>
  <button onclick="show('s006')" id="btn-s006">S-006 案件一覧</button>
  <button onclick="show('s007')" id="btn-s007">S-007 案件登録</button>
  <button onclick="show('s008')" id="btn-s008">S-008 案件詳細</button>
  <button onclick="show('s009')" id="btn-s009">S-009 案件編集</button>
  <button onclick="show('s010')" id="btn-s010">S-010 見積実績</button>
  <button onclick="show('s011')" id="btn-s011">S-011 配送実績</button>
  <button onclick="show('s012')" id="btn-s012">S-012 見積一覧</button>
  <button onclick="show('s013')" id="btn-s013">S-013 搬入不可一覧</button>
  <button onclick="show('s003')" id="btn-s003">S-003 ユーザー一覧</button>
  <button onclick="show('s004')" id="btn-s004">S-004 ユーザー登録</button>
</div>

<div class="screens-wrapper">

  <!-- ========== S-001 ログイン ========== -->
  <div id="s001" class="screen active">
    <div class="content" style="display:flex;flex-direction:column;justify-content:center;min-height:calc(100vh - 48px);">
      <div class="login-logo">
        <div class="logo-icon">🚚</div>
        <h2>家電配送<br>現場向け情報共有システム</h2>
        <p>RideTech</p>
      </div>
      <div class="login-box">
        <div class="form-group">
          <label>ユーザーID</label>
          <input type="text" placeholder="IDを入力" />
        </div>
        <div class="form-group">
          <label>パスワード</label>
          <input type="password" placeholder="パスワードを入力" />
        </div>
        <div class="form-group" style="display:flex;align-items:center;gap:8px;">
          <input type="checkbox" id="auto-login" style="width:auto;" />
          <label for="auto-login" style="margin:0;font-size:13px;color:#444;">この端末でログインを維持する</label>
        </div>
        <button class="btn btn-primary btn-block mt-8" onclick="show('s002')">ログイン</button>
        <p class="text-center text-sm text-muted mt-12">ログインに問題がある場合は管理者へ</p>
      </div>
    </div>
  </div>

  <!-- ========== S-002 トップ画面 ========== -->
  <div id="s002" class="screen">
    <div class="app-header">
      <h1>🚚 RideTech配送</h1>
      <button class="menu-btn">☰</button>
    </div>
    <div class="content">
      <!-- 今日のサマリー -->
      <div class="card mb-8">
        <div class="card-body" style="background:linear-gradient(135deg,#1976d2,#0d47a1);color:#fff;border-radius:12px;">
          <div style="font-size:12px;opacity:.8;margin-bottom:4px;">2025年6月3日（火）</div>
          <div style="font-size:22px;font-weight:700;margin-bottom:12px;">本日の案件</div>
          <div style="display:flex;gap:20px;flex-wrap:wrap;">
            <div style="text-align:center;">
              <div style="font-size:28px;font-weight:700;">15</div>
              <div style="font-size:11px;opacity:.8;">件 / 1号車</div>
            </div>
            <div style="text-align:center;">
              <div style="font-size:28px;font-weight:700;color:#ffcc02;">3</div>
              <div style="font-size:11px;opacity:.8;">見積</div>
            </div>
            <div style="text-align:center;">
              <div style="font-size:28px;font-weight:700;color:#ff6b6b;">3</div>
              <div style="font-size:11px;opacity:.8;">搬入不可</div>
            </div>
          </div>
          <div style="margin-top:12px;padding-top:10px;border-top:1px solid rgba(255,255,255,.3);font-size:12px;opacity:.9;display:flex;gap:16px;flex-wrap:wrap;">
            <span>👷 担当：山田 太郎</span>
            <span>🧑 助手：田中 一郎</span>
            <span>🧑 待機：鈴木 健太</span>
          </div>
        </div>
      </div>

      <!-- メインメニュー -->
      <div class="section-title">メニュー</div>
      <div class="top-grid">
        <div class="top-tile" onclick="show('s006')">
          <div class="tile-icon">📋</div>
          <div class="tile-label">案件一覧</div>
          <div class="tile-badge">15件</div>
        </div>
        <div class="top-tile" onclick="show('s012')">
          <div class="tile-icon">📝</div>
          <div class="tile-label">見積一覧</div>
          <div class="tile-badge">3件</div>
        </div>
        <div class="top-tile" onclick="show('s013')">
          <div class="tile-icon">⚠️</div>
          <div class="tile-label">搬入不可一覧</div>
          <div class="tile-badge">3件</div>
        </div>
        <div class="top-tile" onclick="show('s003')">
          <div class="tile-icon">👥</div>
          <div class="tile-label">ユーザー管理</div>
          <div class="tile-badge" style="background:#f5f5f5;color:#888;">管理者</div>
        </div>
      </div>

      <div class="divider mt-12 mb-8" style="margin:12px -16px 8px;"></div>

      <!-- 最近の更新 -->
      <div class="section-title" style="margin-top:12px;">最近の更新</div>
      <div class="card">
        <div class="list-item">
          <div style="font-size:20px;">📝</div>
          <div class="list-item-main">
            <div class="list-item-name">田中 一郎</div>
            <div class="list-item-sub">見積実績を登録 — 10分前</div>
          </div>
        </div>
        <div class="list-item">
          <div style="font-size:20px;">⚠️</div>
          <div class="list-item-main">
            <div class="list-item-name">佐藤 花子</div>
            <div class="list-item-sub">搬入不可を登録 — 1時間前</div>
          </div>
        </div>
        <div class="list-item">
          <div style="font-size:20px;">✅</div>
          <div class="list-item-main">
            <div class="list-item-name">山田 太郎</div>
            <div class="list-item-sub">配送完了を登録 — 2時間前</div>
          </div>
        </div>
      </div>
    </div>
    <div class="bottom-nav">
      <button class="active"><span class="icon">🏠</span>ホーム</button>
      <button onclick="show('s006')"><span class="icon">📋</span>案件</button>
      <button onclick="show('s007')"><span class="icon">➕</span>登録</button>
      <button><span class="icon">👤</span>アカウント</button>
    </div>
  </div>

  <!-- ========== S-006 案件一覧 ========== -->
  <div id="s006" class="screen">
    <div class="app-header">
      <button class="back-btn" onclick="show('s002')">‹</button>
      <h1>案件一覧</h1>
      <button class="menu-btn" style="font-size:16px;">🗺</button>
    </div>
    <div class="content">
      <!-- 日付セレクタ -->
      <div class="date-selector">
        <button>‹</button>
        <div class="date-text">2025年6月3日（火）</div>
        <button>›</button>
      </div>

      <!-- タブ -->
      <div class="tabs">
        <button class="active" onclick="switchTab(this,'all')">全件 (15)</button>
        <button onclick="switchTab(this,'estimate')">見積 (3)</button>
        <button onclick="switchTab(this,'no-entry')">搬入不可 (3)</button>
      </div>

      <!-- 1号車チーム情報 -->
      <div class="team-bar">
        <div class="team-label">🚚 1号車</div>
        <div class="team-members">
          <div class="member"><span class="role">担当</span><span class="name">山田 太郎</span></div>
          <div class="member"><span class="role">助手</span><span class="name">田中 一郎</span></div>
          <div class="member"><span class="role">待機</span><span class="name">鈴木 健太</span></div>
        </div>
      </div>

      <!-- フィルター・検索 -->
      <div style="display:flex;gap:8px;margin-bottom:12px;">
        <input type="text" placeholder="🔍 氏名・住所で検索" style="flex:1;padding:8px 12px;border:1.5px solid #ddd;border-radius:8px;font-size:13px;" />
      </div>

      <!-- ===== モバイル：カードリスト ===== -->
      <div class="card mobile-list">
        <!-- 案件1 -->
        <div class="list-item" data-caseid="1" data-locked="1" data-addr="東京都足立区千住1-3-8" onclick="show('s008')">
          <div class="order-badge">1</div>
          <div class="list-item-main">
            <div class="list-item-name">中村 義雄</div><div style="margin-top:4px;display:flex;gap:4px;flex-wrap:wrap;"><span style="font-size:10px;background:#f5f5f5;color:#666;padding:1px 6px;border-radius:10px;">📞前TEL</span></div>
            <div class="list-item-sub">東京都足立区千住1-3-8</div>
            <div class="list-item-sub mt-8">冷蔵庫</div>
            <div style="margin-top:5px;display:flex;gap:8px;flex-wrap:wrap;">
              <span style="font-size:11px;color:#bbb;">時間指定：<span style="color:#aaa;">8:00〜10:00</span></span>
              <span style="font-size:11px;color:#888;">予定：<b style="color:#1565c0;">8:00〜10:00</span></span>
            </div>
          </div>
          <div class="list-item-right">
            <span class="badge" style="background:#c8e6c9;color:#1b5e20;">✓ 完了</span>
          </div>
        </div>
        <!-- 案件2 -->
        <div class="list-item" data-caseid="2" data-locked="0" data-addr="東京都葛飾区亀有2-14-5" onclick="show('s008')">
          <div class="order-badge">2</div>
          <div class="list-item-main">
            <div class="list-item-name">小林 恵子</div>
            <div class="list-item-sub">東京都葛飾区亀有2-14-5</div>
            <div class="list-item-sub mt-8">洗濯機</div>
            <div style="margin-top:5px;display:flex;gap:8px;flex-wrap:wrap;">
              <span style="font-size:11px;color:#bbb;">時間指定：<span style="color:#aaa;">なし</span></span>
              <span style="font-size:11px;color:#888;">予定：<b style="color:#1565c0;">8:00〜10:00</span></span>
            </div>
          </div>
          <div class="list-item-right"><span class="badge" style="background:#c8e6c9;color:#1b5e20;">✓ 完了</span></div>
        </div>
        <!-- 案件3 -->
        <div class="list-item" data-caseid="3" data-locked="0" data-addr="東京都江東区木場3-7-2" onclick="show('s008')">
          <div class="order-badge">3</div>
          <div class="list-item-main">
            <div class="list-item-name">佐々木 由美</div>
            <div class="list-item-sub">東京都江東区木場3-7-2</div>
            <div class="list-item-sub mt-8">食洗機・電子レンジ</div>
            <div style="margin-top:5px;display:flex;gap:8px;flex-wrap:wrap;">
              <span style="font-size:11px;color:#bbb;">時間指定：<span style="color:#aaa;">なし</span></span>
              <span style="font-size:11px;color:#888;">予定：<b style="color:#1565c0;">8:00〜10:00</span></span>
            </div>
          </div>
          <div class="list-item-right"><span class="badge" style="background:#c8e6c9;color:#1b5e20;">✓ 完了</span></div>
        </div>
        <!-- 案件4 -->
        <div class="list-item" data-caseid="4" data-locked="1" data-addr="東京都江戸川区西葛西5-2-11" onclick="show('s008')">
          <div class="order-badge">4</div>
          <div class="list-item-main">
            <div class="list-item-name">加藤 誠</div><div style="margin-top:4px;display:flex;gap:4px;flex-wrap:wrap;"><span style="font-size:10px;background:#f5f5f5;color:#666;padding:1px 6px;border-radius:10px;">📞前TEL</span></div>
            <div class="list-item-sub">東京都江戸川区西葛西5-2-11</div>
            <div class="list-item-sub mt-8">エアコン</div>
            <div style="margin-top:5px;display:flex;gap:8px;flex-wrap:wrap;">
              <span style="font-size:11px;color:#bbb;">時間指定：<span style="color:#aaa;">午前中</span></span>
              <span style="font-size:11px;color:#888;">予定：<b style="color:#1565c0;">10:00〜12:00</span></span>
            </div>
          </div>
          <div class="list-item-right"><span class="badge badge-blue">見積</span></div>
        </div>
        <!-- 案件5 -->
        <div class="list-item" data-caseid="5" data-locked="1" data-addr="東京都台東区浅草4-8-15" onclick="show('s008')">
          <div class="order-badge">5</div>
          <div class="list-item-main">
            <div class="list-item-name">渡辺 美穂</div>
            <div class="list-item-sub">東京都台東区浅草4-8-15</div>
            <div class="list-item-sub mt-8">テレビ</div>
            <div style="margin-top:5px;display:flex;gap:8px;flex-wrap:wrap;">
              <span style="font-size:11px;color:#bbb;">時間指定：<span style="color:#aaa;">10:00〜12:00</span></span>
              <span style="font-size:11px;color:#888;">予定：<b style="color:#1565c0;">10:00〜12:00</span></span>
            </div>
          </div>
          <div class="list-item-right"><span class="badge" style="background:#c8e6c9;color:#1b5e20;">✓ 完了</span></div>
        </div>
        <!-- 案件6 -->
        <div class="list-item" data-caseid="6" data-locked="0" data-addr="東京都荒川区西尾久6-3-9" onclick="show('s008')">
          <div class="order-badge">6</div>
          <div class="list-item-main">
            <div class="list-item-name">松本 浩二</div>
            <div class="list-item-sub">東京都荒川区西尾久6-3-9</div>
            <div class="list-item-sub mt-8">冷蔵庫・洗濯機</div>
            <div style="margin-top:5px;display:flex;gap:8px;flex-wrap:wrap;">
              <span style="font-size:11px;color:#bbb;">時間指定：<span style="color:#aaa;">なし</span></span>
              <span style="font-size:11px;color:#888;">予定：<b style="color:#1565c0;">10:00〜12:00</span></span>
            </div>
          </div>
          <div class="list-item-right"><span class="badge badge-blue">見積</span></div>
        </div>
        <!-- 案件7 -->
        <div class="list-item" data-caseid="7" data-locked="0" data-addr="東京都墨田区押上1-1-2" onclick="show('s008')">
          <div class="order-badge" style="background:#e53935;">7</div>
          <div class="list-item-main">
            <div class="list-item-name">伊藤 幸雄</div>
            <div class="list-item-sub">東京都墨田区押上1-1-2</div>
            <div class="list-item-sub mt-8">ドラム式洗濯機</div>
            <div style="margin-top:5px;display:flex;gap:8px;flex-wrap:wrap;">
              <span style="font-size:11px;color:#bbb;">時間指定：<span style="color:#aaa;">なし</span></span>
              <span style="font-size:11px;color:#888;">予定：<b style="color:#1565c0;">12:00〜14:00</span></span>
            </div>
          </div>
          <div class="list-item-right"><span class="badge badge-red">搬入不可</span></div>
        </div>
        <!-- 案件8 -->
        <div class="list-item" data-caseid="8" data-locked="1" data-addr="東京都板橋区常盤台1-9-7" onclick="show('s008')">
          <div class="order-badge">8</div>
          <div class="list-item-main">
            <div class="list-item-name">木村 健太</div><div style="margin-top:4px;display:flex;gap:4px;flex-wrap:wrap;"><span style="font-size:10px;background:#f5f5f5;color:#666;padding:1px 6px;border-radius:10px;">🔧防水パン清掃</span></div>
            <div class="list-item-sub">東京都板橋区常盤台1-9-7</div>
            <div class="list-item-sub mt-8">冷蔵庫</div>
            <div style="margin-top:5px;display:flex;gap:8px;flex-wrap:wrap;">
              <span style="font-size:11px;color:#bbb;">時間指定：<span style="color:#aaa;">12:00〜14:00</span></span>
              <span style="font-size:11px;color:#888;">予定：<b style="color:#1565c0;">12:00〜14:00</span></span>
            </div>
          </div>
          <div class="list-item-right"><span class="badge badge-gray">未完了</span></div>
        </div>
        <!-- 案件9 -->
        <div class="list-item" data-caseid="9" data-locked="0" data-addr="東京都練馬区豊玉北5-14-1" onclick="show('s008')">
          <div class="order-badge">9</div>
          <div class="list-item-main">
            <div class="list-item-name">清水 陽子</div>
            <div class="list-item-sub">東京都練馬区豊玉北5-14-1</div>
            <div class="list-item-sub mt-8">洗濯乾燥機・掃除機</div>
            <div style="margin-top:5px;display:flex;gap:8px;flex-wrap:wrap;">
              <span style="font-size:11px;color:#bbb;">時間指定：<span style="color:#aaa;">なし</span></span>
              <span style="font-size:11px;color:#888;">予定：<b style="color:#1565c0;">12:00〜14:00</span></span>
            </div>
          </div>
          <div class="list-item-right"><span class="badge badge-gray">未完了</span></div>
        </div>
        <!-- 案件10 -->
        <div class="list-item" data-caseid="10" data-locked="1" data-addr="東京都北区赤羽西2-5-3" onclick="show('s008')">
          <div class="order-badge" style="background:#e53935;">10</div>
          <div class="list-item-main">
            <div class="list-item-name">井上 友美</div>
            <div class="list-item-sub">東京都北区赤羽西2-5-3</div>
            <div class="list-item-sub mt-8">エアコン</div>
            <div style="margin-top:5px;display:flex;gap:8px;flex-wrap:wrap;">
              <span style="font-size:11px;color:#bbb;">時間指定：<span style="color:#aaa;">14:00以降</span></span>
              <span style="font-size:11px;color:#888;">予定：<b style="color:#1565c0;">14:00〜16:00</span></span>
            </div>
          </div>
          <div class="list-item-right"><span class="badge badge-red">搬入不可</span></div>
        </div>
        <!-- 案件11 -->
        <div class="list-item" data-caseid="11" data-locked="1" data-addr="東京都中野区新井4-7-3" onclick="show('s008')">
          <div class="order-badge">11</div>
          <div class="list-item-main">
            <div class="list-item-name">中島 さくら</div><div style="margin-top:4px;display:flex;gap:4px;flex-wrap:wrap;"><span style="font-size:10px;background:#f5f5f5;color:#666;padding:1px 6px;border-radius:10px;">📞前TEL</span><span style="font-size:10px;background:#f5f5f5;color:#666;padding:1px 6px;border-radius:10px;">🔧防水パン清掃</span></div>
            <div class="list-item-sub">東京都中野区新井4-7-3</div>
            <div class="list-item-sub mt-8">エアコン</div>
            <div style="margin-top:5px;display:flex;gap:8px;flex-wrap:wrap;">
              <span style="font-size:11px;color:#bbb;">時間指定：<span style="color:#aaa;">14:00〜16:00</span></span>
              <span style="font-size:11px;color:#888;">予定：<b style="color:#1565c0;">14:00〜16:00</span></span>
            </div>
          </div>
          <div class="list-item-right"><span class="badge badge-blue">見積</span></div>
        </div>
        <!-- 案件12 -->
        <div class="list-item" data-caseid="12" data-locked="0" data-addr="東京都豊島区東池袋2-33-10" onclick="show('s008')">
          <div class="order-badge" style="background:#e53935;">12</div>
          <div class="list-item-main">
            <div class="list-item-name">吉田 竜也</div>
            <div class="list-item-sub">東京都豊島区東池袋2-33-10</div>
            <div class="list-item-sub mt-8">冷蔵庫</div>
            <div style="margin-top:5px;display:flex;gap:8px;flex-wrap:wrap;">
              <span style="font-size:11px;color:#bbb;">時間指定：<span style="color:#aaa;">なし</span></span>
              <span style="font-size:11px;color:#888;">予定：<b style="color:#1565c0;">14:00〜16:00</span></span>
            </div>
          </div>
          <div class="list-item-right"><span class="badge badge-red">搬入不可</span></div>
        </div>
        <!-- 案件13 -->
        <div class="list-item" data-caseid="13" data-locked="1" data-addr="東京都杉並区阿佐谷北3-2-6" onclick="show('s008')">
          <div class="order-badge">13</div>
          <div class="list-item-main">
            <div class="list-item-name">山口 正樹</div>
            <div class="list-item-sub">東京都杉並区阿佐谷北3-2-6</div>
            <div class="list-item-sub mt-8">テレビ・ブルーレイ</div>
            <div style="margin-top:5px;display:flex;gap:8px;flex-wrap:wrap;">
              <span style="font-size:11px;color:#bbb;">時間指定：<span style="color:#aaa;">16:00〜18:00</span></span>
              <span style="font-size:11px;color:#888;">予定：<b style="color:#1565c0;">16:00〜18:00</span></span>
            </div>
          </div>
          <div class="list-item-right"><span class="badge badge-gray">未完了</span></div>
        </div>
        <!-- 案件14 -->
        <div class="list-item" data-caseid="14" data-locked="0" data-addr="東京都新宿区大久保1-5-2" onclick="show('s008')">
          <div class="order-badge">14</div>
          <div class="list-item-main">
            <div class="list-item-name">藤田 香織</div>
            <div class="list-item-sub">東京都新宿区大久保1-5-2</div>
            <div class="list-item-sub mt-8">洗濯機</div>
            <div style="margin-top:5px;display:flex;gap:8px;flex-wrap:wrap;">
              <span style="font-size:11px;color:#bbb;">時間指定：<span style="color:#aaa;">なし</span></span>
              <span style="font-size:11px;color:#888;">予定：<b style="color:#1565c0;">16:00〜18:00</span></span>
            </div>
          </div>
          <div class="list-item-right"><span class="badge badge-gray">未完了</span></div>
        </div>
        <!-- 案件15 -->
        <div class="list-item" data-caseid="15" data-locked="0" data-addr="東京都渋谷区代々木上原1-22-4" onclick="show('s008')">
          <div class="order-badge">15</div>
          <div class="list-item-main">
            <div class="list-item-name">橋本 俊介</div>
            <div class="list-item-sub">東京都渋谷区代々木上原1-22-4</div>
            <div class="list-item-sub mt-8">ドラム式洗濯機・冷蔵庫</div>
            <div style="margin-top:5px;display:flex;gap:8px;flex-wrap:wrap;">
              <span style="font-size:11px;color:#bbb;">時間指定：<span style="color:#aaa;">なし</span></span>
              <span style="font-size:11px;color:#888;">予定：<b style="color:#1565c0;">16:00〜18:00</span></span>
            </div>
          </div>
          <div class="list-item-right"><span class="badge badge-gray">未完了</span></div>
        </div>
      </div>

      <!-- ===== タブレット：テーブル表示 ===== -->
      <div class="card tablet-table" style="display:none;">
        <div class="case-table">
          <div class="case-table-head">
            <div class="case-row">
              <div class="case-cell col-order">順</div>
              <div class="case-cell col-name">氏名</div>
              <div class="case-cell col-addr">住所</div>
              <div class="case-cell col-item">商品</div>
              <div class="case-cell col-wish">時間指定</div>
              <div class="case-cell col-plan">訪問予定</div>
              <div class="case-cell col-status">状況</div>
            </div>
          </div>
          <div class="case-table-body">
            <div class="case-row" onclick="show('s008')">
              <div class="case-cell col-order"><div class="order-badge" style="width:26px;height:26px;font-size:12px;margin:auto;">1</div></div>
              <div class="case-cell col-name">中村 義雄<div class="sub-addr">足立区千住1-3-8</div></div>
              <div class="case-cell col-addr">足立区千住1-3-8</div>
              <div class="case-cell col-item">冷蔵庫</div>
              <div class="case-cell col-wish">8:00〜10:00</div>
              <div class="case-cell col-plan">8:00〜10:00</div>
              <div class="case-cell col-status"><span class="badge" style="background:#c8e6c9;color:#1b5e20;">✓完了</span></div>
            </div>
            <div class="case-row" onclick="show('s008')">
              <div class="case-cell col-order"><div class="order-badge" style="width:26px;height:26px;font-size:12px;margin:auto;">2</div></div>
              <div class="case-cell col-name">小林 恵子<div class="sub-addr">葛飾区亀有2-14-5</div></div>
              <div class="case-cell col-addr">葛飾区亀有2-14-5</div>
              <div class="case-cell col-item">洗濯機</div>
              <div class="case-cell col-wish">—</div>
              <div class="case-cell col-plan">8:00〜10:00</div>
              <div class="case-cell col-status"><span class="badge" style="background:#c8e6c9;color:#1b5e20;">✓完了</span></div>
            </div>
            <div class="case-row" onclick="show('s008')">
              <div class="case-cell col-order"><div class="order-badge" style="width:26px;height:26px;font-size:12px;margin:auto;">3</div></div>
              <div class="case-cell col-name">佐々木 由美<div class="sub-addr">江東区木場3-7-2</div></div>
              <div class="case-cell col-addr">江東区木場3-7-2</div>
              <div class="case-cell col-item">食洗機・電子レンジ</div>
              <div class="case-cell col-wish">—</div>
              <div class="case-cell col-plan">8:00〜10:00</div>
              <div class="case-cell col-status"><span class="badge" style="background:#c8e6c9;color:#1b5e20;">✓完了</span></div>
            </div>
            <div class="case-row" onclick="show('s008')">
              <div class="case-cell col-order"><div class="order-badge" style="width:26px;height:26px;font-size:12px;margin:auto;">4</div></div>
              <div class="case-cell col-name">加藤 誠<div class="sub-addr">江戸川区西葛西5-2-11</div></div>
              <div class="case-cell col-addr">江戸川区西葛西5-2-11</div>
              <div class="case-cell col-item">エアコン</div>
              <div class="case-cell col-wish">午前中</div>
              <div class="case-cell col-plan">10:00〜12:00</div>
              <div class="case-cell col-status"><span class="badge badge-blue">見積</span></div>
            </div>
            <div class="case-row" onclick="show('s008')">
              <div class="case-cell col-order"><div class="order-badge" style="width:26px;height:26px;font-size:12px;margin:auto;">5</div></div>
              <div class="case-cell col-name">渡辺 美穂<div class="sub-addr">台東区浅草4-8-15</div></div>
              <div class="case-cell col-addr">台東区浅草4-8-15</div>
              <div class="case-cell col-item">テレビ</div>
              <div class="case-cell col-wish">10:00〜12:00</div>
              <div class="case-cell col-plan">10:00〜12:00</div>
              <div class="case-cell col-status"><span class="badge" style="background:#c8e6c9;color:#1b5e20;">✓完了</span></div>
            </div>
            <div class="case-row" onclick="show('s008')">
              <div class="case-cell col-order"><div class="order-badge" style="width:26px;height:26px;font-size:12px;margin:auto;">6</div></div>
              <div class="case-cell col-name">松本 浩二<div class="sub-addr">荒川区西尾久6-3-9</div></div>
              <div class="case-cell col-addr">荒川区西尾久6-3-9</div>
              <div class="case-cell col-item">冷蔵庫・洗濯機</div>
              <div class="case-cell col-wish">—</div>
              <div class="case-cell col-plan">10:00〜12:00</div>
              <div class="case-cell col-status"><span class="badge badge-blue">見積</span></div>
            </div>
            <div class="case-row" onclick="show('s008')" style="background:#fff5f5;">
              <div class="case-cell col-order"><div class="order-badge" style="width:26px;height:26px;font-size:12px;margin:auto;background:#e53935;">7</div></div>
              <div class="case-cell col-name">伊藤 幸雄<div class="sub-addr">墨田区押上1-1-2</div></div>
              <div class="case-cell col-addr">墨田区押上1-1-2</div>
              <div class="case-cell col-item">ドラム式洗濯機</div>
              <div class="case-cell col-wish">—</div>
              <div class="case-cell col-plan">12:00〜14:00</div>
              <div class="case-cell col-status"><span class="badge badge-red">搬入不可</span></div>
            </div>
            <div class="case-row" onclick="show('s008')">
              <div class="case-cell col-order"><div class="order-badge" style="width:26px;height:26px;font-size:12px;margin:auto;">8</div></div>
              <div class="case-cell col-name">木村 健太<div class="sub-addr">板橋区常盤台1-9-7</div></div>
              <div class="case-cell col-addr">板橋区常盤台1-9-7</div>
              <div class="case-cell col-item">冷蔵庫</div>
              <div class="case-cell col-wish">12:00〜14:00</div>
              <div class="case-cell col-plan">12:00〜14:00</div>
              <div class="case-cell col-status"><span class="badge badge-gray">未完了</span></div>
            </div>
            <div class="case-row" onclick="show('s008')">
              <div class="case-cell col-order"><div class="order-badge" style="width:26px;height:26px;font-size:12px;margin:auto;">9</div></div>
              <div class="case-cell col-name">清水 陽子<div class="sub-addr">練馬区豊玉北5-14-1</div></div>
              <div class="case-cell col-addr">練馬区豊玉北5-14-1</div>
              <div class="case-cell col-item">洗濯乾燥機・掃除機</div>
              <div class="case-cell col-wish">—</div>
              <div class="case-cell col-plan">12:00〜14:00</div>
              <div class="case-cell col-status"><span class="badge badge-gray">未完了</span></div>
            </div>
            <div class="case-row" onclick="show('s008')" style="background:#fff5f5;">
              <div class="case-cell col-order"><div class="order-badge" style="width:26px;height:26px;font-size:12px;margin:auto;background:#e53935;">10</div></div>
              <div class="case-cell col-name">井上 友美<div class="sub-addr">北区赤羽西2-5-3</div></div>
              <div class="case-cell col-addr">北区赤羽西2-5-3</div>
              <div class="case-cell col-item">エアコン</div>
              <div class="case-cell col-wish">14:00以降</div>
              <div class="case-cell col-plan">14:00〜16:00</div>
              <div class="case-cell col-status"><span class="badge badge-red">搬入不可</span></div>
            </div>
            <div class="case-row" onclick="show('s008')">
              <div class="case-cell col-order"><div class="order-badge" style="width:26px;height:26px;font-size:12px;margin:auto;">11</div></div>
              <div class="case-cell col-name">中島 さくら<div class="sub-addr">中野区新井4-7-3</div></div>
              <div class="case-cell col-addr">中野区新井4-7-3</div>
              <div class="case-cell col-item">エアコン</div>
              <div class="case-cell col-wish">14:00〜16:00</div>
              <div class="case-cell col-plan">14:00〜16:00</div>
              <div class="case-cell col-status"><span class="badge badge-blue">見積</span></div>
            </div>
            <div class="case-row" onclick="show('s008')" style="background:#fff5f5;">
              <div class="case-cell col-order"><div class="order-badge" style="width:26px;height:26px;font-size:12px;margin:auto;background:#e53935;">12</div></div>
              <div class="case-cell col-name">吉田 竜也<div class="sub-addr">豊島区東池袋2-33-10</div></div>
              <div class="case-cell col-addr">豊島区東池袋2-33-10</div>
              <div class="case-cell col-item">冷蔵庫</div>
              <div class="case-cell col-wish">—</div>
              <div class="case-cell col-plan">14:00〜16:00</div>
              <div class="case-cell col-status"><span class="badge badge-red">搬入不可</span></div>
            </div>
            <div class="case-row" onclick="show('s008')">
              <div class="case-cell col-order"><div class="order-badge" style="width:26px;height:26px;font-size:12px;margin:auto;">13</div></div>
              <div class="case-cell col-name">山口 正樹<div class="sub-addr">杉並区阿佐谷北3-2-6</div></div>
              <div class="case-cell col-addr">杉並区阿佐谷北3-2-6</div>
              <div class="case-cell col-item">テレビ・ブルーレイ</div>
              <div class="case-cell col-wish">16:00〜18:00</div>
              <div class="case-cell col-plan">16:00〜18:00</div>
              <div class="case-cell col-status"><span class="badge badge-gray">未完了</span></div>
            </div>
            <div class="case-row" onclick="show('s008')">
              <div class="case-cell col-order"><div class="order-badge" style="width:26px;height:26px;font-size:12px;margin:auto;">14</div></div>
              <div class="case-cell col-name">藤田 香織<div class="sub-addr">新宿区大久保1-5-2</div></div>
              <div class="case-cell col-addr">新宿区大久保1-5-2</div>
              <div class="case-cell col-item">洗濯機（ES-W114）</div>
              <div class="case-cell col-wish">—</div>
              <div class="case-cell col-plan">16:00〜18:00</div>
              <div class="case-cell col-status"><span class="badge badge-gray">未完了</span></div>
            </div>
            <div class="case-row" onclick="show('s008')">
              <div class="case-cell col-order"><div class="order-badge" style="width:26px;height:26px;font-size:12px;margin:auto;">15</div></div>
              <div class="case-cell col-name">橋本 俊介<div class="sub-addr">渋谷区代々木上原1-22-4</div></div>
              <div class="case-cell col-addr">渋谷区代々木上原1-22-4</div>
              <div class="case-cell col-item">ドラム式洗濯機・冷蔵庫</div>
              <div class="case-cell col-wish">—</div>
              <div class="case-cell col-plan">16:00〜18:00</div>
              <div class="case-cell col-status"><span class="badge badge-gray">未完了</span></div>
            </div>
          </div>
        </div>
      </div>

      <!-- マップ・最適化ボタン -->
      <div class="row mt-12">
        <button class="btn btn-outline btn-block">🗺 マップ表示</button>
        <button class="btn btn-primary btn-block" onclick="startOptimize()">⚡ 訪問順最適化</button>
      </div>

      <!-- 最適化結果バナー（非表示→表示） -->
      <div id="opt-result" style="display:none;margin-top:12px;background:#e8f5e9;border:1.5px solid #a5d6a7;border-radius:10px;padding:12px 14px;">
        <div style="font-weight:700;color:#2e7d32;margin-bottom:6px;">✅ 最適化完了</div>
        <div style="font-size:12px;color:#444;line-height:1.8;">
          移動距離：<b>47.3km → 31.8km</b>（約33%削減）<br>
          移動時間：<b>2時間41分 → 1時間52分</b>（約30%削減）<br>
          🔒 時間指定あり：<b>5件固定</b>　🔀 並び替え：<b>10件</b>
        </div>
        <div style="margin-top:10px;display:flex;gap:8px;">
          <button class="btn btn-primary btn-sm" onclick="applyOptimize()" style="flex:1;">この順番で確定</button>
          <button class="btn btn-outline btn-sm" onclick="resetOptimize()" style="flex:1;">元に戻す</button>
        </div>
      </div>

      <!-- ルート地図 -->
      <div id="route-map-container" style="display:none;margin-top:12px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
          <div style="font-weight:700;font-size:13px;color:#1565c0;">🗺 最適ルート地図</div>
          <button onclick="document.getElementById('route-map-container').style.display='none'" style="font-size:11px;color:#1976d2;background:none;border:none;cursor:pointer;padding:2px 8px;">非表示 ✕</button>
        </div>
        <div id="route-map" style="height:260px;border-radius:12px;overflow:hidden;border:1px solid #ddd;"></div>
      </div>

      <!-- 最適化中オーバーレイ -->
      <div id="opt-overlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:999;align-items:center;justify-content:center;flex-direction:column;gap:16px;">
        <div style="background:#fff;border-radius:16px;padding:28px 32px;text-align:center;max-width:280px;">
          <div style="font-size:36px;margin-bottom:12px;">🗺</div>
          <div style="font-weight:700;font-size:16px;margin-bottom:8px;">ルートを計算中...</div>
          <div style="font-size:12px;color:#888;margin-bottom:16px;">Google Maps APIで<br>15件の最適順を算出しています</div>
          <div style="height:6px;background:#e0e0e0;border-radius:3px;overflow:hidden;">
            <div id="opt-progress" style="height:100%;background:#1976d2;border-radius:3px;width:0%;transition:width .1s;"></div>
          </div>
          <div id="opt-step" style="font-size:11px;color:#aaa;margin-top:8px;">住所を解析中...</div>
        </div>
      </div>
    </div>

    <!-- FAB 新規登録 -->
    <button class="fab" onclick="show('s007')">＋</button>

    <div class="bottom-nav">
      <button onclick="show('s002')"><span class="icon">🏠</span>ホーム</button>
      <button class="active"><span class="icon">📋</span>案件</button>
      <button onclick="show('s007')"><span class="icon">➕</span>登録</button>
      <button><span class="icon">👤</span>アカウント</button>
    </div>
  </div>

  <!-- ========== S-007 新規案件登録 ========== -->
  <div id="s007" class="screen">
    <div class="app-header">
      <button class="back-btn" onclick="show('s006')">‹</button>
      <h1>新規案件登録</h1>
      <div></div>
    </div>
    <div class="content">

      <!-- 帳票スキャン -->
      <div style="background:#e8f4fd;border:1.5px dashed #90caf9;border-radius:12px;padding:16px;margin-bottom:16px;text-align:center;">
        <div style="font-size:13px;color:#1565c0;font-weight:700;margin-bottom:8px;">📷 設置明細票を読み込む</div>
        <div style="font-size:11px;color:#888;margin-bottom:12px;">カメラで帳票を撮影すると氏名・住所・電話番号・時間指定を自動入力します</div>
        <div style="display:flex;gap:8px;justify-content:center;">
          <button class="btn btn-primary btn-sm" onclick="demoScan()">📷 カメラ起動</button>
          <button class="btn btn-outline btn-sm" onclick="demoScan()">🖼 画像を選択</button>
        </div>
        <div id="scan-status" style="display:none;margin-top:10px;font-size:12px;color:#1976d2;">
          ⏳ 読み取り中...
        </div>
        <div id="scan-result" style="display:none;margin-top:10px;font-size:12px;background:#fff;border-radius:8px;padding:8px;text-align:left;border:1px solid #bbdefb;">
          <div style="color:#2e7d32;font-weight:700;margin-bottom:4px;">✅ 読み取り完了 — 以下の内容を自動入力しました</div>
          <div style="color:#555;">氏名：平林 伸子　／　電話：090-6563-7237</div>
          <div style="color:#555;">住所：東京都大田区中央4-9-2</div>
          <div style="color:#555;">時間指定：12:00〜15:00　／　訪問種別：見積</div>
          <div style="color:#e65100;margin-top:4px;">⚠ 確認が必要な項目：購入品（手動選択）</div>
        </div>
      </div>

      <div class="section-title">訪問情報</div>
      <div class="card">
        <div class="card-body">
          <div class="form-group">
            <label>訪問種別</label>
            <select id="f-type">
              <option>配送</option>
              <option>見積</option>
            </select>
          </div>
          <div class="form-group">
            <label>時間指定</label>
            <select id="f-time">
              <option value="">なし</option>
              <option>9:00〜12:00</option>
              <option>12:00〜15:00</option>
              <option>15:00〜18:00</option>
            </select>
          </div>
        </div>
      </div>

      <div class="section-title mt-12">顧客情報</div>
      <div class="card">
        <div class="card-body">
          <div class="form-group">
            <label>氏名</label>
            <input id="f-name" type="text" placeholder="例：山田 太郎" />
          </div>
          <div class="form-group">
            <label>電話番号</label>
            <input id="f-tel" type="tel" placeholder="090-0000-0000" />
          </div>
          <div class="form-group">
            <label>住所</label>
            <input id="f-addr" type="text" placeholder="東京都○○区..." />
          </div>
          <div class="form-group">
            <label>建物名・部屋番号</label>
            <input type="text" placeholder="例：ABCマンション302号室" />
          </div>
        </div>
      </div>

      <div class="section-title mt-12">現場情報</div>
      <div class="card">
        <div class="card-body">
          <div class="form-group">
            <label>設置階数</label>
            <div style="display:flex;gap:8px;align-items:center;">
              <select style="width:auto;padding:10px 12px;border:1.5px solid #ddd;border-radius:8px;font-size:14px;">
                <option>1階</option>
                <option>内階段</option>
                <option>外階段</option>
                <option>EV</option>
              </select>
              <input type="number" placeholder="階" min="1" style="width:72px;" />
              <span style="font-size:14px;color:#666;">F</span>
            </div>
            <div style="font-size:11px;color:#bbb;margin-top:4px;">1階の場合は階数入力不要</div>
          </div>
          <div class="form-group">
            <label>エレベーター</label>
            <div style="display:flex;gap:16px;margin-top:4px;">
              <label style="display:flex;align-items:center;gap:6px;font-size:14px;"><input type="radio" name="elevator" /> 有</label>
              <label style="display:flex;align-items:center;gap:6px;font-size:14px;"><input type="radio" name="elevator" /> 無</label>
              <label style="display:flex;align-items:center;gap:6px;font-size:14px;color:#aaa;"><input type="radio" name="elevator" checked /> 未確認</label>
            </div>
          </div>
          <div class="form-group">
            <label>トラック駐車スペース</label>
            <input type="text" placeholder="例：建物前 路駐可 / ○○P利用" />
          </div>
          <div class="form-group">
            <label>お客様との約束事</label>
            <textarea placeholder="例：搬入前に呼び鈴。ペットあり。"></textarea>
          </div>
          <div class="form-group">
            <label>連絡事項</label>
            <textarea placeholder="例：前TEL必須（09:00以降）。不在時は再訪問不可。"></textarea>
          </div>
          <div class="form-group">
            <label>特殊作業</label>
            <div style="display:flex;flex-direction:column;gap:10px;margin-top:4px;">
              <label style="display:flex;align-items:center;gap:10px;font-size:14px;">
                <input type="checkbox" style="width:18px;height:18px;" /> 📞 前TEL
              </label>
              <label style="display:flex;align-items:center;gap:10px;font-size:14px;">
                <input type="checkbox" style="width:18px;height:18px;" /> 🔧 防水パン清掃
              </label>
              <label style="display:flex;align-items:center;gap:10px;font-size:14px;color:#aaa;">
                <input type="checkbox" style="width:18px;height:18px;" disabled /> ＋ 項目追加予定
              </label>
            </div>
          </div>
        </div>
      </div>

      <div class="section-title mt-12">購入品</div>
      <div class="card">
        <div class="card-body">
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:2px;">
            <label style="display:flex;align-items:center;gap:8px;padding:8px 4px;font-size:13px;border-bottom:1px solid #f5f5f5;">
              <input type="checkbox" style="width:18px;height:18px;flex-shrink:0;" /> 冷蔵庫（大）
            </label>
            <label style="display:flex;align-items:center;gap:8px;padding:8px 4px;font-size:13px;border-bottom:1px solid #f5f5f5;">
              <input type="checkbox" style="width:18px;height:18px;flex-shrink:0;" /> 冷蔵庫（小）
            </label>
            <label style="display:flex;align-items:center;gap:8px;padding:8px 4px;font-size:13px;border-bottom:1px solid #f5f5f5;">
              <input type="checkbox" style="width:18px;height:18px;flex-shrink:0;" /> 洗濯機
            </label>
            <label style="display:flex;align-items:center;gap:8px;padding:8px 4px;font-size:13px;border-bottom:1px solid #f5f5f5;">
              <input type="checkbox" style="width:18px;height:18px;flex-shrink:0;" /> ドラム型洗濯機
            </label>
            <label style="display:flex;align-items:center;gap:8px;padding:8px 4px;font-size:13px;border-bottom:1px solid #f5f5f5;">
              <input type="checkbox" style="width:18px;height:18px;flex-shrink:0;" /> 乾燥機
            </label>
            <label style="display:flex;align-items:center;gap:8px;padding:8px 4px;font-size:13px;border-bottom:1px solid #f5f5f5;">
              <input type="checkbox" style="width:18px;height:18px;flex-shrink:0;" /> TV 50型未満
            </label>
            <label style="display:flex;align-items:center;gap:8px;padding:8px 4px;font-size:13px;border-bottom:1px solid #f5f5f5;">
              <input type="checkbox" style="width:18px;height:18px;flex-shrink:0;" /> TV 50型以上
            </label>
            <label style="display:flex;align-items:center;gap:8px;padding:8px 4px;font-size:13px;border-bottom:1px solid #f5f5f5;">
              <input type="checkbox" style="width:18px;height:18px;flex-shrink:0;" /> TV 65型以上
            </label>
            <label style="display:flex;align-items:center;gap:8px;padding:8px 4px;font-size:13px;border-bottom:1px solid #f5f5f5;">
              <input type="checkbox" style="width:18px;height:18px;flex-shrink:0;" /> TV 75型以上
            </label>
            <label style="display:flex;align-items:center;gap:8px;padding:8px 4px;font-size:13px;border-bottom:1px solid #f5f5f5;">
              <input type="checkbox" style="width:18px;height:18px;flex-shrink:0;" /> TVスタンド
            </label>
            <label style="display:flex;align-items:center;gap:8px;padding:8px 4px;font-size:13px;border-bottom:1px solid #f5f5f5;">
              <input type="checkbox" style="width:18px;height:18px;flex-shrink:0;" /> ソファ
            </label>
            <label style="display:flex;align-items:center;gap:8px;padding:8px 4px;font-size:13px;border-bottom:1px solid #f5f5f5;">
              <input type="checkbox" style="width:18px;height:18px;flex-shrink:0;" /> 電動マッサージ
            </label>
            <label style="display:flex;align-items:center;gap:8px;padding:8px 4px;font-size:13px;border-bottom:1px solid #f5f5f5;">
              <input type="checkbox" style="width:18px;height:18px;flex-shrink:0;" /> ベッド
            </label>
            <label style="display:flex;align-items:center;gap:8px;padding:8px 4px;font-size:13px;border-bottom:1px solid #f5f5f5;">
              <input type="checkbox" style="width:18px;height:18px;flex-shrink:0;" /> 電子レンジ
            </label>
            <label style="display:flex;align-items:center;gap:8px;padding:8px 4px;font-size:13px;">
              <input type="checkbox" style="width:18px;height:18px;flex-shrink:0;" /> 炊飯器
            </label>
          </div>
        </div>
      </div>

      <div class="row mt-16">
        <button class="btn btn-outline btn-block" onclick="show('s006')">キャンセル</button>
        <button class="btn btn-primary btn-block" onclick="show('s006')">登録する</button>
      </div>
    </div>
  </div>

  <!-- ========== S-008 案件詳細 ========== -->
  <div id="s008" class="screen">
    <div class="app-header">
      <button class="back-btn" onclick="show('s006')">‹</button>
      <h1>案件詳細</h1>
      <button class="menu-btn" style="font-size:14px;" onclick="show('s009')">編集</button>
    </div>
    <div class="content">
      <!-- 基本情報 -->
      <div class="card">
        <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;">
          <span>📋 基本情報</span>
          <span class="badge badge-blue">見積</span>
        </div>
        <div class="card-body">
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;" class="detail-grid">
            <div><div class="text-sm text-muted">日付</div><div style="font-weight:600;">2025/06/03</div></div>
            <div><div class="text-sm text-muted">訪問順</div><div style="font-weight:600;">4番目</div></div>
            <div><div class="text-sm text-muted">時間指定</div><div style="color:#aaa;">午前中</div></div>
            <div><div class="text-sm text-muted">訪問予定時間</div><div style="font-weight:700;color:#1565c0;">10:00〜12:00</div></div>
          </div>
          <div style="margin-top:12px;padding-top:10px;border-top:1px solid #eee;">
            <div class="text-sm text-muted" style="margin-bottom:6px;">担当チーム（1号車）</div>
            <div style="display:flex;gap:16px;flex-wrap:wrap;font-size:13px;">
              <span>👷 <b>担当</b>：山田 太郎</span>
              <span>🧑 <b>助手</b>：田中 一郎</span>
              <span>🧑 <b>待機</b>：鈴木 健太</span>
            </div>
          </div>
        </div>
      </div>

      <!-- 顧客情報 -->
      <div class="card">
        <div class="card-header">👤 顧客情報</div>
        <div class="card-body">
          <div style="font-size:18px;font-weight:700;margin-bottom:8px;">田中 花子</div>
          <div class="text-sm" style="margin-bottom:6px;">📞 090-1234-5678</div>
          <div class="text-sm" style="margin-bottom:6px;">📍 東京都新宿区西新宿2-8-1 ABCマンション302号室</div>
          <div class="row mt-12">
            <button class="btn btn-outline btn-block btn-sm">📞 発信</button>
            <button class="btn btn-outline btn-block btn-sm" onclick="openNavigation('東京都新宿区西新宿2-8-1')">🗺 地図を開く</button>
          </div>
        </div>
      </div>

      <!-- 現場情報 -->
      <div class="card">
        <div class="card-header">🏠 現場情報</div>
        <div class="card-body">
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:12px;">
            <div>
              <div class="text-sm text-muted">設置階数</div>
              <div style="font-weight:600;">内3F</div>
            </div>
            <div>
              <div class="text-sm text-muted">エレベーター</div>
              <div style="font-weight:600;">なし</div>
            </div>
            <div>
              <div class="text-sm text-muted">トラック駐車</div>
              <div style="font-weight:600;">建物前 路駐可</div>
            </div>
          </div>
          <div style="border-top:1px solid #eee;padding-top:10px;margin-bottom:8px;">
            <div class="text-sm text-muted" style="margin-bottom:4px;">お客様との約束事</div>
            <div style="font-size:13px;">搬入前に必ず呼び鈴を押すこと。ペットあり（室内犬）。</div>
          </div>
          <div style="border-top:1px solid #eee;padding-top:10px;">
            <div class="text-sm text-muted" style="margin-bottom:4px;">連絡事項</div>
            <div style="font-size:13px;">前TEL必須（09:00以降）。不在時は再訪問不可のため注意。</div>
          </div>
        </div>
      </div>

      <!-- 購入品 -->
      <div class="card">
        <div class="card-header">📦 購入品</div>
        <div class="card-body">
          <div>エアコン（CS-X224D）</div>
        </div>
      </div>

      <!-- 見積実績（アコーディオン） -->
      <div class="card" style="overflow:visible;">
        <div class="accordion-header" onclick="toggleAccordion(this)">
          <span>📝 見積実績</span>
          <div style="display:flex;align-items:center;gap:8px;">
            <span class="badge badge-green">搬入可</span>
            <span>▼</span>
          </div>
        </div>
        <div class="accordion-body open">
          <div style="margin-bottom:8px;"><span class="text-sm text-muted">搬入可否：</span><span class="badge badge-green">搬入可</span></div>
          <div style="margin-bottom:8px;"><span class="text-sm text-muted">担当：</span>山田 太郎｜2025/05/28</div>
          <div style="margin-bottom:10px;"><span class="text-sm text-muted">コメント：</span><br>階段幅は問題なし。3階まで人力で搬入可能。エアコン室外機の設置場所は南側ベランダ確認済み。</div>
          <div class="photo-thumbs">
            <div class="photo-thumb">🏠</div>
            <div class="photo-thumb">🪜</div>
            <div class="photo-thumb">🔌</div>
          </div>
          <button class="btn btn-outline btn-block btn-sm mt-12" onclick="show('s010')">実績を編集</button>
        </div>
      </div>

      <!-- 配送実績 -->
      <div class="card">
        <div class="accordion-header" onclick="toggleAccordion(this)" style="background:#f1f8e9;">
          <span>✅ 配送実績</span>
          <div style="display:flex;align-items:center;gap:8px;">
            <span class="badge badge-gray">未登録</span>
            <span>▼</span>
          </div>
        </div>
        <div class="accordion-body">
          <p class="text-muted text-sm">まだ配送実績が登録されていません。</p>
          <button class="btn btn-primary btn-block btn-sm mt-12" onclick="show('s011')">配送実績を登録</button>
        </div>
      </div>

      <button class="btn btn-outline btn-block mt-12" onclick="show('s010')">📝 見積実績を登録・編集</button>
    </div>
  </div>

  <!-- ========== S-009 案件編集 ========== -->
  <div id="s009" class="screen">
    <div class="app-header">
      <button class="back-btn" onclick="show('s008')">‹</button>
      <h1>案件編集</h1>
      <div></div>
    </div>
    <div class="content">
      <div class="section-title">訪問情報</div>
      <div class="card">
        <div class="card-body">
          <div class="form-group">
            <label>訪問種別</label>
            <select><option>見積</option><option>配送</option></select>
          </div>
          <div class="form-group">
            <label>時間指定</label>
            <select>
              <option value="">なし</option>
              <option selected>9:00〜12:00</option>
              <option>12:00〜15:00</option>
              <option>15:00〜18:00</option>
            </select>
          </div>
        </div>
      </div>

      <div class="section-title mt-12">顧客情報</div>
      <div class="card">
        <div class="card-body">
          <div class="form-group"><label>氏名</label><input type="text" value="田中 花子" /></div>
          <div class="form-group"><label>電話番号</label><input type="tel" value="090-1234-5678" /></div>
          <div class="form-group"><label>住所</label><input type="text" value="東京都新宿区西新宿2-8-1" /></div>
          <div class="form-group">
            <label>建物名・部屋番号</label>
            <input type="text" value="ABCマンション302号室" />
          </div>
        </div>
      </div>

      <div class="section-title mt-12">現場情報</div>
      <div class="card">
        <div class="card-body">
          <div class="form-group">
            <label>設置階数</label>
            <div style="display:flex;gap:8px;align-items:center;">
              <select style="width:auto;padding:10px 12px;border:1.5px solid #ddd;border-radius:8px;font-size:14px;">
                <option>1階</option>
                <option selected>内階段</option>
                <option>外階段</option>
                <option>EV</option>
              </select>
              <input type="number" value="3" style="width:72px;" />
              <span style="font-size:14px;color:#666;">F</span>
            </div>
          </div>
          <div class="form-group">
            <label>エレベーター</label>
            <div style="display:flex;gap:16px;margin-top:4px;">
              <label style="display:flex;align-items:center;gap:6px;font-size:14px;"><input type="radio" name="elev2" /> 有</label>
              <label style="display:flex;align-items:center;gap:6px;font-size:14px;"><input type="radio" name="elev2" /> 無</label>
              <label style="display:flex;align-items:center;gap:6px;font-size:14px;color:#aaa;"><input type="radio" name="elev2" checked /> 未確認</label>
            </div>
          </div>
          <div class="form-group">
            <label>トラック駐車スペース</label>
            <input type="text" value="建物前 路駐可" />
          </div>
          <div class="form-group">
            <label>お客様との約束事</label>
            <textarea>搬入前に必ず呼び鈴を押すこと。ペットあり（室内犬）。</textarea>
          </div>
          <div class="form-group">
            <label>連絡事項</label>
            <textarea>前TEL必須（09:00以降）。不在時は再訪問不可のため注意。</textarea>
          </div>
          <div class="form-group">
            <label>特殊作業</label>
            <div style="display:flex;flex-direction:column;gap:10px;margin-top:4px;">
              <label style="display:flex;align-items:center;gap:10px;font-size:14px;">
                <input type="checkbox" checked style="width:18px;height:18px;" /> 📞 前TEL
              </label>
              <label style="display:flex;align-items:center;gap:10px;font-size:14px;">
                <input type="checkbox" style="width:18px;height:18px;" /> 🔧 防水パン清掃
              </label>
              <label style="display:flex;align-items:center;gap:10px;font-size:14px;color:#aaa;">
                <input type="checkbox" style="width:18px;height:18px;" disabled /> ＋ 項目追加予定
              </label>
            </div>
          </div>
        </div>
      </div>

      <div class="section-title mt-12">購入品</div>
      <div class="card">
        <div class="card-body">
          <div class="form-group"><label>商品名</label><input type="text" value="エアコン" /></div>
        </div>
      </div>

      <div class="row mt-16">
        <button class="btn btn-danger btn-block" style="flex:.6;">🗑 削除</button>
        <button class="btn btn-outline btn-block" onclick="show('s008')">キャンセル</button>
        <button class="btn btn-primary btn-block" onclick="show('s008')">保存する</button>
      </div>
    </div>
  </div>

  <!-- ========== S-010 見積実績登録・編集 ========== -->
  <div id="s010" class="screen">
    <div class="app-header">
      <button class="back-btn" onclick="show('s008')">‹</button>
      <h1>見積実績</h1>
      <div></div>
    </div>
    <div class="content">
      <div class="card" style="background:#e3f2fd;border-radius:12px;padding:12px 16px;margin-bottom:16px;">
        <div style="font-weight:700;">田中 花子</div>
        <div class="text-sm text-muted">東京都新宿区西新宿2-8-1</div>
      </div>

      <div class="form-group">
        <label>搬入可否</label>
        <div style="display:flex;gap:12px;margin-top:4px;">
          <label style="display:flex;align-items:center;gap:6px;font-size:14px;color:#2e7d32;">
            <input type="radio" name="result" checked /> 搬入可
          </label>
          <label style="display:flex;align-items:center;gap:6px;font-size:14px;color:#c62828;">
            <input type="radio" name="result" /> 搬入不可
          </label>
          <label style="display:flex;align-items:center;gap:6px;font-size:14px;color:#e65100;">
            <input type="radio" name="result" /> 条件付き可
          </label>
        </div>
      </div>

      <div class="form-group">
        <label>コメント・注意点</label>
        <textarea placeholder="搬入経路・注意点・特記事項を記入">階段幅は問題なし。3階まで人力で搬入可能。エアコン室外機の設置場所は南側ベランダ確認済み。</textarea>
      </div>

      <div class="form-group">
        <label>現場写真</label>
        <div class="photo-upload">📷 タップして写真を追加<br><span style="font-size:11px;">（カメラ撮影またはライブラリから選択）</span></div>
        <div class="photo-thumbs mt-8">
          <div class="photo-thumb">🏠</div>
          <div class="photo-thumb">🪜</div>
          <div class="photo-thumb" style="background:#e3f2fd;color:#1976d2;border:2px dashed #90caf9;">＋</div>
        </div>
      </div>

      <div class="row mt-16">
        <button class="btn btn-outline btn-block" onclick="show('s008')">キャンセル</button>
        <button class="btn btn-primary btn-block" onclick="show('s008')">保存する</button>
      </div>
    </div>
  </div>

  <!-- ========== S-011 配送実績登録・編集 ========== -->
  <div id="s011" class="screen">
    <div class="app-header">
      <button class="back-btn" onclick="show('s008')">‹</button>
      <h1>配送実績</h1>
      <div></div>
    </div>
    <div class="content">
      <div class="card" style="background:#e8f5e9;border-radius:12px;padding:12px 16px;margin-bottom:16px;">
        <div style="font-weight:700;">田中 花子</div>
        <div class="text-sm text-muted">東京都新宿区西新宿2-8-1 — エアコン</div>
      </div>

      <div class="form-group">
        <label>搬入可否</label>
        <div style="display:flex;gap:12px;margin-top:4px;">
          <label style="display:flex;align-items:center;gap:6px;font-size:14px;color:#2e7d32;">
            <input type="radio" name="delivery" checked /> 搬入完了
          </label>
          <label style="display:flex;align-items:center;gap:6px;font-size:14px;color:#c62828;">
            <input type="radio" name="delivery" /> 搬入不可
          </label>
        </div>
      </div>

      <!-- 搬入不可時の追加情報（表示切替） -->
      <div class="card" style="border:1.5px solid #ffcdd2;">
        <div class="card-header" style="background:#ffebee;color:#c62828;">⚠️ 搬入不可の場合（詳細）</div>
        <div class="card-body">
          <div class="form-group">
            <label>不可理由</label>
            <textarea placeholder="不可理由を具体的に記入..."></textarea>
          </div>
          <div class="form-group">
            <label>今後の対応</label>
            <select>
              <option>選択してください</option>
              <option>再配送</option>
              <option>クレーン見積</option>
              <option>商品変更</option>
              <option>キャンセル</option>
              <option>その他</option>
            </select>
          </div>
          <div class="form-group">
            <label>現場写真</label>
            <div class="photo-upload">📷 タップして写真を追加</div>
          </div>
        </div>
      </div>

      <div class="form-group mt-12">
        <label>コメント</label>
        <textarea placeholder="引き渡し状況や特記事項を記入..."></textarea>
      </div>

      <div class="row mt-16">
        <button class="btn btn-outline btn-block" onclick="show('s008')">キャンセル</button>
        <button class="btn btn-primary btn-block" onclick="show('s008')">保存する</button>
      </div>
    </div>
  </div>

  <!-- ========== S-012 見積一覧 ========== -->
  <div id="s012" class="screen">
    <div class="app-header">
      <button class="back-btn" onclick="show('s002')">‹</button>
      <h1>見積一覧</h1>
      <div></div>
    </div>
    <div class="content">
      <!-- 検索・フィルター -->
      <div style="display:flex;gap:8px;margin-bottom:12px;">
        <input type="text" placeholder="🔍 氏名・住所で検索" style="flex:1;padding:8px 12px;border:1.5px solid #ddd;border-radius:8px;font-size:13px;" />
        <input type="month" value="2025-06" style="padding:8px;border:1.5px solid #ddd;border-radius:8px;font-size:13px;" />
      </div>
      <div style="display:flex;gap:8px;margin-bottom:16px;">
        <select style="flex:1;padding:8px;border:1.5px solid #ddd;border-radius:8px;font-size:13px;">
          <option>担当：全員</option>
          <option>山田</option>
          <option>田中</option>
        </select>
        <select style="flex:1;padding:8px;border:1.5px solid #ddd;border-radius:8px;font-size:13px;">
          <option>搬入可否：全て</option>
          <option>搬入可</option>
          <option>搬入不可</option>
          <option>条件付き可</option>
        </select>
      </div>

      <div class="card">
        <div class="list-item" onclick="show('s008')">
          <div style="font-size:20px;">📝</div>
          <div class="list-item-main">
            <div class="list-item-name">加藤 誠</div>
            <div class="list-item-sub">東京都江戸川区西葛西5-2-11</div>
            <div class="list-item-sub">エアコン｜2025/06/03｜山田</div>
          </div>
          <div class="list-item-right">
            <span class="badge badge-gray">未登録</span>
          </div>
        </div>
        <div class="list-item" onclick="show('s008')">
          <div style="font-size:20px;">📝</div>
          <div class="list-item-main">
            <div class="list-item-name">松本 浩二</div>
            <div class="list-item-sub">東京都荒川区西尾久6-3-9</div>
            <div class="list-item-sub">冷蔵庫・洗濯機｜2025/06/03｜鈴木</div>
            <div style="margin-top:4px;font-size:11px;color:#888;">前回見積：2025/05/20 搬入可</div>
          </div>
          <div class="list-item-right">
            <span class="badge badge-green">搬入可</span>
          </div>
        </div>
        <div class="list-item" onclick="show('s008')">
          <div style="font-size:20px;">📝</div>
          <div class="list-item-main">
            <div class="list-item-name">中島 さくら</div>
            <div class="list-item-sub">東京都中野区新井4-7-3</div>
            <div class="list-item-sub">エアコン｜2025/06/03｜田中</div>
            <div style="margin-top:4px;font-size:11px;color:#e65100;">⚠ 前回：条件付き可（クレーン要確認）</div>
          </div>
          <div class="list-item-right">
            <span class="badge badge-orange">条件付き可</span>
          </div>
        </div>
      </div>
    </div>
    <div class="bottom-nav">
      <button onclick="show('s002')"><span class="icon">🏠</span>ホーム</button>
      <button onclick="show('s006')"><span class="icon">📋</span>案件</button>
      <button class="active"><span class="icon">📝</span>見積</button>
      <button onclick="show('s013')"><span class="icon">⚠️</span>搬入不可</button>
    </div>
  </div>

  <!-- ========== S-013 搬入不可一覧 ========== -->
  <div id="s013" class="screen">
    <div class="app-header">
      <button class="back-btn" onclick="show('s002')">‹</button>
      <h1>搬入不可一覧</h1>
      <div></div>
    </div>
    <div class="content">
      <div style="display:flex;gap:8px;margin-bottom:12px;">
        <input type="text" placeholder="🔍 氏名・住所で検索" style="flex:1;padding:8px 12px;border:1.5px solid #ddd;border-radius:8px;font-size:13px;" />
        <input type="month" value="2025-06" style="padding:8px;border:1.5px solid #ddd;border-radius:8px;font-size:13px;" />
      </div>
      <div style="margin-bottom:16px;">
        <select style="width:100%;padding:8px;border:1.5px solid #ddd;border-radius:8px;font-size:13px;">
          <option>対応状況：全て</option>
          <option>再配送待ち</option>
          <option>クレーン見積中</option>
          <option>商品変更中</option>
          <option>対応完了</option>
        </select>
      </div>

      <div class="card">
        <div class="list-item" onclick="show('s008')">
          <div style="font-size:20px;">⚠️</div>
          <div class="list-item-main">
            <div class="list-item-name">伊藤 幸雄</div>
            <div class="list-item-sub">東京都墨田区押上1-1-2</div>
            <div class="list-item-sub">ドラム式洗濯機｜2025/06/03｜山田</div>
            <div class="list-item-sub mt-8" style="color:#c62828;">理由：玄関ドア幅68cm・搬入不可</div>
            <div style="margin-top:6px;"><span class="badge badge-orange">再配送待ち</span></div>
          </div>
          <div class="list-item-right"><span>›</span></div>
        </div>
        <div class="list-item" onclick="show('s008')">
          <div style="font-size:20px;">⚠️</div>
          <div class="list-item-main">
            <div class="list-item-name">井上 友美</div>
            <div class="list-item-sub">東京都北区赤羽西2-5-3</div>
            <div class="list-item-sub">エアコン｜2025/06/03｜山田</div>
            <div class="list-item-sub mt-8" style="color:#c62828;">理由：室外機置き場なし・クレーン検討</div>
            <div style="margin-top:6px;"><span class="badge badge-blue">クレーン見積中</span></div>
          </div>
          <div class="list-item-right"><span>›</span></div>
        </div>
        <div class="list-item" onclick="show('s008')">
          <div style="font-size:20px;">⚠️</div>
          <div class="list-item-main">
            <div class="list-item-name">吉田 竜也</div>
            <div class="list-item-sub">東京都豊島区東池袋2-33-10</div>
            <div class="list-item-sub">冷蔵庫｜2025/06/03｜鈴木</div>
            <div class="list-item-sub mt-8" style="color:#c62828;">理由：エレベーター容量不足・搬入経路確認中</div>
            <div style="margin-top:6px;"><span class="badge badge-gray">対応検討中</span></div>
          </div>
          <div class="list-item-right"><span>›</span></div>
        </div>
      </div>
    </div>
    <div class="bottom-nav">
      <button onclick="show('s002')"><span class="icon">🏠</span>ホーム</button>
      <button onclick="show('s006')"><span class="icon">📋</span>案件</button>
      <button onclick="show('s012')"><span class="icon">📝</span>見積</button>
      <button class="active"><span class="icon">⚠️</span>搬入不可</button>
    </div>
  </div>

  <!-- ========== S-003 ユーザー一覧 ========== -->
  <div id="s003" class="screen">
    <div class="app-header">
      <button class="back-btn" onclick="show('s002')">‹</button>
      <h1>ユーザー一覧</h1>
      <div></div>
    </div>
    <div class="content">
      <div class="card">
        <div class="list-item" onclick="show('s005')">
          <div style="font-size:28px;">👤</div>
          <div class="list-item-main">
            <div class="list-item-name">山田 太郎</div>
            <div class="list-item-sub">ID: yamada</div>
          </div>
          <div class="list-item-right">
            <span class="badge badge-red">管理者</span>
          </div>
        </div>
        <div class="list-item" onclick="show('s005')">
          <div style="font-size:28px;">👤</div>
          <div class="list-item-main">
            <div class="list-item-name">田中 一郎</div>
            <div class="list-item-sub">ID: tanaka</div>
          </div>
          <div class="list-item-right">
            <span class="badge badge-blue">リーダー</span>
          </div>
        </div>
        <div class="list-item" onclick="show('s005')">
          <div style="font-size:28px;">👤</div>
          <div class="list-item-main">
            <div class="list-item-name">鈴木 健太</div>
            <div class="list-item-sub">ID: suzuki</div>
          </div>
          <div class="list-item-right">
            <span class="badge badge-gray">一般</span>
          </div>
        </div>
      </div>
      <button class="btn btn-primary btn-block mt-16" onclick="show('s004')">＋ 新規ユーザー登録</button>
    </div>
  </div>

  <!-- ========== S-004 ユーザー登録 ========== -->
  <div id="s004" class="screen">
    <div class="app-header">
      <button class="back-btn" onclick="show('s003')">‹</button>
      <h1>ユーザー登録</h1>
      <div></div>
    </div>
    <div class="content">
      <div class="card">
        <div class="card-body">
          <div class="form-group"><label>ユーザー名</label><input type="text" placeholder="例：山田 太郎" /></div>
          <div class="form-group"><label>ユーザーID</label><input type="text" placeholder="例：yamada" /></div>
          <div class="form-group">
            <label>権限</label>
            <select>
              <option>一般</option>
              <option>リーダー</option>
              <option>管理者</option>
            </select>
          </div>
          <div class="form-group"><label>パスワード</label><input type="password" placeholder="パスワードを設定" /></div>
          <div class="form-group"><label>パスワード（確認）</label><input type="password" placeholder="もう一度入力" /></div>
        </div>
      </div>
      <div class="row mt-16">
        <button class="btn btn-outline btn-block" onclick="show('s003')">キャンセル</button>
        <button class="btn btn-primary btn-block" onclick="show('s003')">登録する</button>
      </div>
    </div>
  </div>

  <!-- ========== S-005 ユーザー編集・削除（ナビから直接は未設定、S-003から遷移） ========== -->
  <div id="s005" class="screen">
    <div class="app-header">
      <button class="back-btn" onclick="show('s003')">‹</button>
      <h1>ユーザー編集</h1>
      <div></div>
    </div>
    <div class="content">
      <div class="card">
        <div class="card-body">
          <div class="form-group"><label>ユーザー名</label><input type="text" value="田中 一郎" /></div>
          <div class="form-group"><label>ユーザーID</label><input type="text" value="tanaka" /></div>
          <div class="form-group">
            <label>権限</label>
            <select><option>一般</option><option selected>リーダー</option><option>管理者</option></select>
          </div>
          <div class="form-group"><label>新しいパスワード（変更する場合のみ）</label><input type="password" placeholder="新しいパスワード" /></div>
        </div>
      </div>
      <div class="row mt-16">
        <button class="btn btn-danger btn-block" style="flex:.6;" onclick="show('s003')">🗑 削除</button>
        <button class="btn btn-outline btn-block" onclick="show('s003')">キャンセル</button>
        <button class="btn btn-primary btn-block" onclick="show('s003')">保存する</button>
      </div>
    </div>
  </div>

</div><!-- /screens-wrapper -->

<script>
  // ===== Google Maps 初期化 =====
  // ※ Google Maps APIの読み込み完了後に呼ばれるコールバック関数
  let directionsService = null;
  let directionsRenderer = null;

  function initGoogleMaps() {
    directionsService = new google.maps.DirectionsService();
    directionsRenderer = new google.maps.DirectionsRenderer({
      polylineOptions: { strokeColor: '#1976d2', strokeWeight: 5, strokeOpacity: 0.8 },
      markerOptions: { visible: true }
    });
  }

  // ===== 出発地（デポ・倉庫住所） =====
  const DEPOT_ADDRESS = '東京都台東区上野7-1-1';

  // ===== 訪問順最適化（Directions API） =====
  let originalOrder = null;

  function startOptimize() {
    if (!directionsService) {
      alert('Google Maps APIが読み込まれていません。\nAPIキーを確認してください。');
      return;
    }

    const overlay = document.getElementById('opt-overlay');
    const progress = document.getElementById('opt-progress');
    const step = document.getElementById('opt-step');
    const result = document.getElementById('opt-result');

    result.style.display = 'none';
    document.getElementById('route-map-container').style.display = 'none';
    overlay.style.display = 'flex';
    progress.style.width = '0%';

    // 未完了案件のみ取得（✓完了バッジを除外）
    const allItems = Array.from(document.querySelectorAll('.mobile-list .list-item'));
    const activeItems = allItems.filter(el => {
      const badge = el.querySelector('.list-item-right .badge');
      return !badge || !badge.textContent.includes('✓');
    });

    if (activeItems.length < 2) {
      overlay.style.display = 'none';
      alert('最適化するには2件以上の未完了案件が必要です');
      return;
    }

    const addresses = activeItems.map(el => el.dataset.addr);

    setProgress(progress, step, 15, '住所を解析中...');

    setTimeout(() => {
      setProgress(progress, step, 40, 'Google Maps APIに送信中...');

      const request = {
        origin: DEPOT_ADDRESS,
        destination: DEPOT_ADDRESS,
        waypoints: addresses.map(addr => ({ location: addr, stopover: true })),
        optimizeWaypoints: true,
        travelMode: google.maps.TravelMode.DRIVING,
        region: 'jp'
      };

      setTimeout(() => setProgress(progress, step, 58, '最適ルートを計算中...'), 500);

      directionsService.route(request, (response, status) => {
        if (status !== 'OK') {
          overlay.style.display = 'none';
          alert('ルート計算に失敗しました。\nステータス: ' + status + '\n\nAPIキーの制限設定（HTTPリファラー / Directions API）を確認してください。');
          return;
        }

        setProgress(progress, step, 76, '時間指定を考慮して調整中...');

        // Directions APIが返す最適化済みのwaypoint順序
        const waypointOrder = response.routes[0].waypoint_order;
        const reorderedActive = waypointOrder.map(i => activeItems[i]);

        // 総移動距離・時間を集計（depotの往復legを除く）
        const legs = response.routes[0].legs;
        let totalDistM = 0, totalDurSec = 0;
        legs.forEach(leg => { totalDistM += leg.distance.value; totalDurSec += leg.duration.value; });
        const totalDistKm = (totalDistM / 1000).toFixed(1);
        const totalHr = Math.floor(totalDurSec / 3600);
        const totalMin = Math.floor((totalDurSec % 3600) / 60);

        setProgress(progress, step, 92, '訪問順を確定中...');

        setTimeout(() => {
          setProgress(progress, step, 100, '完了');
          setTimeout(() => {
            overlay.style.display = 'none';
            applyRealOptimize(reorderedActive, allItems, totalDistKm, totalHr, totalMin, response);
            result.style.display = 'block';
            result.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
          }, 300);
        }, 600);
      });
    }, 700);
  }

  function setProgress(bar, label, pct, text) {
    bar.style.width = pct + '%';
    label.textContent = text;
  }

  function applyRealOptimize(reorderedActive, allItems, distKm, hr, min, routeResponse) {
    const list = document.querySelector('.mobile-list');
    if (!list) return;

    // 元の順序を保存
    if (!originalOrder) originalOrder = allItems.map(el => el.cloneNode(true));

    // 完了済み案件を先頭に、最適化後の未完了案件を後ろに並べる
    const completedItems = allItems.filter(el => {
      const badge = el.querySelector('.list-item-right .badge');
      return badge && badge.textContent.includes('✓');
    });

    [...completedItems, ...reorderedActive].forEach((el, idx) => {
      if (!el) return;
      list.appendChild(el);
      const badge = el.querySelector('.order-badge');
      if (badge) {
        badge.textContent = idx + 1;
        const isLocked = el.dataset.locked === '1';
        badge.style.outline = isLocked ? '2px solid #ce93d8' : '2px solid #90caf9';
        badge.style.background = isLocked ? '#7b1fa2' : '#1976d2';
        const existingLock = badge.querySelector('.lock-icon');
        if (isLocked && !existingLock) {
          const lock = document.createElement('span');
          lock.className = 'lock-icon';
          lock.style.cssText = 'font-size:9px;position:absolute;bottom:-3px;right:-3px;';
          lock.textContent = '🔒';
          badge.style.position = 'relative';
          badge.appendChild(lock);
        }
      }
      if (el.dataset.locked !== '1') {
        el.style.background = '#fffde7';
        setTimeout(() => { el.style.background = ''; }, 2500);
      }
    });

    // 最適化結果バナーを実データで更新
    const resultDiv = document.getElementById('opt-result');
    resultDiv.querySelector('div[style*="font-size:12px"]').innerHTML =
      `移動距離（往復含む）：<b>${distKm}km</b><br>` +
      `移動時間（往復含む）：<b>${hr}時間${min}分</b><br>` +
      `🔒 時間指定あり：<b>${reorderedActive.filter(e=>e.dataset.locked==='1').length}件固定</b>　` +
      `🔀 並び替え：<b>${reorderedActive.filter(e=>e.dataset.locked==='0').length}件</b>`;

    // 地図にルートを描画
    const mapContainer = document.getElementById('route-map-container');
    const mapEl = document.getElementById('route-map');
    mapContainer.style.display = 'block';

    const map = new google.maps.Map(mapEl, {
      zoom: 12,
      center: { lat: 35.6896, lng: 139.6921 },
      mapTypeControl: false,
      streetViewControl: false,
      fullscreenControl: false
    });
    directionsRenderer.setMap(map);
    directionsRenderer.setDirections(routeResponse);
  }

  function applyOptimize() {
    document.querySelectorAll('.mobile-list .list-item').forEach(el => {
      const badge = el.querySelector('.order-badge');
      if (badge) badge.style.outline = '';
    });
    document.getElementById('opt-result').style.display = 'none';
    const toast = document.createElement('div');
    toast.style.cssText = 'position:fixed;bottom:80px;left:50%;transform:translateX(-50%);background:#2e7d32;color:#fff;padding:10px 20px;border-radius:20px;font-size:13px;font-weight:700;z-index:9999;box-shadow:0 4px 12px rgba(0,0,0,.3);';
    toast.textContent = '✅ 訪問順を確定しました';
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 2500);
  }

  function resetOptimize() {
    if (!originalOrder) return;
    const list = document.querySelector('.mobile-list');
    originalOrder.forEach((el, idx) => {
      list.appendChild(el);
      const badge = el.querySelector('.order-badge');
      if (badge) {
        badge.textContent = idx + 1;
        badge.style.background = [7, 10, 12].includes(idx + 1) ? '#e53935' : '#1976d2';
        badge.style.outline = '';
        const lock = badge.querySelector('.lock-icon');
        if (lock) lock.remove();
      }
      el.style.background = '';
    });
    originalOrder = null;
    document.getElementById('opt-result').style.display = 'none';
    document.getElementById('route-map-container').style.display = 'none';
    if (directionsRenderer) directionsRenderer.setMap(null);
  }

  // ===== 地図を開く（Googleマップナビ） =====
  function openNavigation(address) {
    const encoded = encodeURIComponent(address);
    window.open('https://www.google.com/maps/dir/?api=1&destination=' + encoded, '_blank');
  }


  // 帳票スキャンデモ
  function demoScan() {
    const status = document.getElementById('scan-status');
    const result = document.getElementById('scan-result');
    status.style.display = 'block';
    result.style.display = 'none';
    setTimeout(() => {
      status.style.display = 'none';
      result.style.display = 'block';
      // フォームへ自動入力（設置明細票の内容）
      const name = document.getElementById('f-name');
      const tel  = document.getElementById('f-tel');
      const addr = document.getElementById('f-addr');
      const type = document.getElementById('f-type');
      const time = document.getElementById('f-time');
      if (name) name.value = '平林 伸子';
      if (tel)  tel.value  = '090-6563-7237';
      if (addr) addr.value = '東京都大田区中央4-9-2';
      if (type) type.value = '見積';
      if (time) { for (let o of time.options) { if (o.value === '12:00〜15:00') o.selected = true; } }
      // 入力欄をハイライト
      [name, tel, addr].forEach(el => {
        if (!el) return;
        el.style.borderColor = '#43a047';
        el.style.background  = '#f1f8e9';
        setTimeout(() => { el.style.borderColor = ''; el.style.background = ''; }, 3000);
      });
    }, 1800);
  }

  function show(id) {
    document.querySelectorAll('.screen').forEach(s => s.classList.remove('active'));
    document.querySelectorAll('#nav-bar button').forEach(b => b.classList.remove('active'));
    document.getElementById(id).classList.add('active');
    const btn = document.getElementById('btn-' + id);
    if (btn) btn.classList.add('active');
    window.scrollTo(0, 0);
  }

  function switchTab(el, tab) {
    el.closest('.tabs').querySelectorAll('button').forEach(b => b.classList.remove('active'));
    el.classList.add('active');
  }

  function toggleAccordion(header) {
    const body = header.nextElementSibling;
    body.classList.toggle('open');
    const arrow = header.querySelector('span:last-child');
    if (arrow) arrow.textContent = body.classList.contains('open') ? '▲' : '▼';
  }
</script>
  <!-- ===== Google Maps JavaScript API =====
       YOUR_API_KEY の部分を発行済みのAPIキーに置き換えてください
       例: ?key=AIzaSyABC123...&callback=initGoogleMaps
  -->
  <script
    src="https://maps.googleapis.com/maps/api/js?key={{ $googleMapsApiKey }}&callback=initGoogleMaps&language=ja&region=JP"
    async defer>
  </script>
</body>
</html>
