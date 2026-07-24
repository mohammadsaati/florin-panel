<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظرسنجی | گلفروشی فلورین</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --rose-deep:    #7B1340;
            --rose-dark:    #A0174F;
            --rose-mid:     #C2185B;
            --rose-main:    #E91E63;
            --rose-soft:    #F06292;
            --rose-light:   #F8BBD0;
            --rose-pale:    #FCE4EC;
            --rose-blush:   #FFF0F5;
            --cream:        #FFFBF7;
            --green-leaf:   #388E3C;
            --green-stem:   #2E7D32;
            --gold:         #F9A825;
            --text-dark:    #3D0020;
            --text-mid:     #7B1340;
            --text-soft:    #B06080;
            --text-light:   #D4A0B0;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Vazirmatn', sans-serif;
            min-height: 100vh;
            background: #FFF0F5;
            color: var(--text-dark);
            overflow-x: hidden;
            position: relative;
        }

        /* ═══════════════════════════════════════
           LAYERED BACKGROUND
        ═══════════════════════════════════════ */
        .bg-scene {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
        }

        /* Light floral gradient backdrop */
        .bg-gradient {
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 20% 10%,  #FFD6E7 0%, transparent 60%),
                radial-gradient(ellipse 60% 80% at 80% 90%,  #F8BBD0 0%, transparent 55%),
                radial-gradient(ellipse 100% 100% at 50% 50%, #FFF0F5 0%, #FCE4EC 100%);
        }

        /* Bokeh orbs */
        .bokeh {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            pointer-events: none;
        }
        .bokeh-1 { width: 600px; height: 600px; background: #F48FB1; opacity: 0.35; top: -150px; left: -100px; animation: drift1 18s ease-in-out infinite; }
        .bokeh-2 { width: 400px; height: 400px; background: #E91E63; opacity: 0.15; top: 40%; right: -80px; animation: drift2 22s ease-in-out infinite; }
        .bokeh-3 { width: 350px; height: 350px; background: #F8BBD0; opacity: 0.5; bottom: -100px; left: 30%; animation: drift1 15s ease-in-out infinite reverse; }
        .bokeh-4 { width: 250px; height: 250px; background: #CE93D8; opacity: 0.18; top: 25%; left: 40%; animation: drift2 12s ease-in-out infinite; }
        .bokeh-5 { width: 200px; height: 200px; background: #F9A825; opacity: 0.1;  bottom: 20%; right: 20%; animation: drift1 20s ease-in-out infinite 5s; }

        @keyframes drift1 {
            0%,100% { transform: translate(0, 0) scale(1); }
            33%      { transform: translate(30px, -20px) scale(1.05); }
            66%      { transform: translate(-20px, 30px) scale(0.95); }
        }
        @keyframes drift2 {
            0%,100% { transform: translate(0, 0) scale(1); }
            50%      { transform: translate(-40px, 20px) scale(1.08); }
        }

        /* Sparkles (soft rose on light bg) */
        .sparkle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: #E91E63;
            border-radius: 50%;
            animation: twinkle var(--d, 3s) ease-in-out infinite var(--delay, 0s);
            opacity: 0;
        }
        @keyframes twinkle {
            0%,100% { opacity: 0; transform: scale(0.5); }
            50%      { opacity: 0.35; transform: scale(1.5); }
        }

        /* ═══════════════════════════════════════
           PETALS
        ═══════════════════════════════════════ */
        .petal-layer {
            position: absolute;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
        }
        .petal {
            position: absolute;
            top: -80px;
            opacity: 0;
            animation: petalFall var(--dur, 10s) var(--ease, ease-in) var(--delay, 0s) infinite;
        }
        .petal svg {
            display: block;
            width: 100%;
            height: 100%;
        }
        @keyframes petalFall {
            0%   { transform: translateY(0) translateX(0) rotate(var(--r0, 0deg)); opacity: 0; }
            8%   { opacity: var(--op, 0.8); }
            85%  { opacity: var(--op, 0.6); }
            100% { transform: translateY(110vh) translateX(var(--dx, 40px)) rotate(var(--r1, 360deg)); opacity: 0; }
        }

        /* ═══════════════════════════════════════
           LARGE DECORATIVE FLOWER - BOTTOM RIGHT
        ═══════════════════════════════════════ */
        .deco-flower {
            position: fixed;
            pointer-events: none;
            z-index: 1;
        }
        .deco-flower.br {
            bottom: -60px; right: -60px;
            opacity: 0.18;
            animation: slowspin 40s linear infinite;
        }
        .deco-flower.tl {
            top: -80px; left: -80px;
            opacity: 0.12;
            animation: slowspin 50s linear infinite reverse;
        }
        @keyframes slowspin { to { transform: rotate(360deg); } }

        /* ═══════════════════════════════════════
           PROGRESS BAR (TOP)
        ═══════════════════════════════════════ */
        .progress-bar-wrap {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: rgba(255,255,255,0.08);
            z-index: 100;
        }
        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--rose-soft), var(--gold), var(--rose-main));
            width: 0%;
            transition: width 0.3s ease;
            box-shadow: 0 0 8px rgba(233,30,99,0.6);
        }

        /* ═══════════════════════════════════════
           MAIN LAYOUT
        ═══════════════════════════════════════ */
        .page-wrap {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 4rem 1rem 3rem;
        }

        /* ═══════════════════════════════════════
           HERO SECTION
        ═══════════════════════════════════════ */
        .hero {
            text-align: center;
            margin-bottom: 3rem;
            animation: heroIn 1s cubic-bezier(0.22, 1, 0.36, 1) both;
        }
        @keyframes heroIn {
            from { opacity: 0; transform: translateY(-30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .hero-flower {
            display: inline-block;
            margin-bottom: 1.5rem;
            animation: float 5s ease-in-out infinite;
            filter: drop-shadow(0 8px 32px rgba(233,30,99,0.5)) drop-shadow(0 0 60px rgba(233,30,99,0.3));
        }
        @keyframes float {
            0%,100% { transform: translateY(0) rotate(-2deg); }
            50%      { transform: translateY(-14px) rotate(2deg); }
        }

        .brand-name {
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 900;
            letter-spacing: -1px;
            background: linear-gradient(135deg, #FFCDD2 0%, #F8BBD0 30%, #F48FB1 60%, #F06292 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
            text-shadow: none;
        }

        .brand-tagline {
            font-size: 1rem;
            font-weight: 400;
            color: rgba(176, 96, 128, 0.75);
            letter-spacing: 1px;
        }

        /* ═══════════════════════════════════════
           MAIN CARD
        ═══════════════════════════════════════ */
        .card {
            width: 100%;
            max-width: 640px;
            background: rgba(255, 255, 255, 0.72);
            backdrop-filter: blur(40px) saturate(180%);
            -webkit-backdrop-filter: blur(40px) saturate(180%);
            border-radius: 2.5rem;
            border: 1px solid rgba(233,30,99,0.12);
            box-shadow:
                0 0 0 1px rgba(255,255,255,0.8),
                0 40px 100px rgba(233,30,99,0.12),
                0 8px 40px rgba(0,0,0,0.08),
                inset 0 1px 0 rgba(255,255,255,0.95);
            overflow: hidden;
            animation: cardIn 1s cubic-bezier(0.22, 1, 0.36, 1) 0.2s both;
        }
        @keyframes cardIn {
            from { opacity: 0; transform: translateY(40px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .card-inner { padding: 2.5rem; }

        /* ═══════════════════════════════════════
           PHONE FORM
        ═══════════════════════════════════════ */
        .section-divider {
            display: flex; align-items: center; gap: 1rem;
            margin: 1.75rem 0; font-size: 0.8rem;
            color: rgba(176, 96, 128, 0.6);
        }
        .section-divider::before, .section-divider::after {
            content: ''; flex: 1; height: 1px;
            background: linear-gradient(to right, transparent, rgba(233,30,99,0.25), transparent);
        }

        .form-label {
            display: block;
            font-size: 0.85rem; font-weight: 600;
            color: #7B1340;
            margin-bottom: 0.6rem;
        }

        .input-row { display: flex; gap: 0.75rem; }

        .phone-input {
            flex: 1;
            padding: 1rem 1.25rem;
            border-radius: 1.25rem;
            border: 1.5px solid rgba(233,30,99,0.25);
            background: rgba(255,255,255,0.85);
            color: #3D0020;
            font-family: 'Vazirmatn', sans-serif;
            font-size: 1.15rem;
            outline: none;
            transition: all 0.3s ease;
            text-align: center;
            letter-spacing: 3px;
            direction: ltr;
        }
        .phone-input::placeholder {
            letter-spacing: 0; color: rgba(176,96,128,0.45);
            font-size: 0.875rem; direction: rtl;
        }
        .phone-input:focus {
            border-color: var(--rose-main);
            background: white;
            box-shadow: 0 0 0 4px rgba(233,30,99,0.12), 0 2px 12px rgba(233,30,99,0.1);
        }

        .btn-rose {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 1rem 1.75rem;
            border-radius: 1.25rem;
            background: linear-gradient(135deg, #E91E63, #C2185B);
            color: white; border: none; cursor: pointer;
            font-family: 'Vazirmatn', sans-serif;
            font-size: 0.95rem; font-weight: 700;
            white-space: nowrap;
            transition: all 0.3s ease;
            box-shadow: 0 6px 24px rgba(233,30,99,0.45), 0 2px 8px rgba(0,0,0,0.3);
            position: relative; overflow: hidden;
        }
        .btn-rose::before {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
            opacity: 0; transition: opacity 0.3s;
        }
        .btn-rose:hover::before { opacity: 1; }
        .btn-rose:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 32px rgba(233,30,99,0.55), 0 4px 12px rgba(0,0,0,0.3);
        }
        .btn-rose:active { transform: translateY(0); }
        .btn-rose:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

        .btn-ghost {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.7rem 1.4rem;
            border-radius: 1rem;
            background: rgba(233,30,99,0.06);
            border: 1px solid rgba(233,30,99,0.18);
            color: #C2185B;
            font-family: 'Vazirmatn', sans-serif;
            font-size: 0.85rem; font-weight: 600;
            text-decoration: none; cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-ghost:hover {
            background: rgba(233,30,99,0.12);
            color: #880E4F;
            border-color: rgba(233,30,99,0.35);
        }

        .error-msg {
            color: #C62828; font-size: 0.8rem; margin-top: 0.5rem;
            display: flex; align-items: center; gap: 0.3rem;
        }

        /* ═══════════════════════════════════════
           NOT FOUND STATE
        ═══════════════════════════════════════ */
        .not-found-box {
            margin-top: 2rem;
            background: rgba(255,50,50,0.08);
            border: 1px solid rgba(255,100,100,0.2);
            border-radius: 1.5rem;
            padding: 2rem;
            text-align: center;
            animation: slideUp 0.4s cubic-bezier(0.22,1,0.36,1);
        }
        .not-found-icon { font-size: 3rem; margin-bottom: 1rem; display: block; animation: shake 0.5s ease 0.4s; }
        @keyframes shake {
            0%,100%{transform:rotate(0)} 25%{transform:rotate(-10deg)} 75%{transform:rotate(10deg)}
        }
        .not-found-box h3 { color: #FF8A80; font-size: 1.1rem; font-weight: 700; margin-bottom: 0.6rem; }
        .not-found-box p { color: rgba(255,180,180,0.7); font-size: 0.875rem; line-height: 1.8; }

        /* ═══════════════════════════════════════
           SUCCESS STATE
        ═══════════════════════════════════════ */
        .success-box {
            margin-bottom: 2rem;
            background: rgba(50,200,100,0.08);
            border: 1px solid rgba(100,220,130,0.2);
            border-radius: 1.5rem;
            padding: 1.5rem;
            text-align: center;
            animation: successBounce 0.6s cubic-bezier(0.22,1,0.36,1);
        }
        @keyframes successBounce {
            0%   { opacity: 0; transform: scale(0.8); }
            60%  { transform: scale(1.04); }
            100% { opacity: 1; transform: scale(1); }
        }
        .success-box p { color: #A5F3AE; font-size: 0.9rem; font-weight: 500; }

        /* ═══════════════════════════════════════
           USER GREETING STRIP
        ═══════════════════════════════════════ */
        .user-strip {
            display: flex; align-items: center; gap: 1rem;
            background: linear-gradient(135deg, rgba(233,30,99,0.15), rgba(194,24,91,0.08));
            border: 1px solid rgba(233,30,99,0.2);
            border-radius: 1.5rem;
            padding: 1.25rem 1.5rem;
            margin-bottom: 2rem;
            animation: slideUp 0.5s cubic-bezier(0.22,1,0.36,1);
        }
        .user-avatar-ring {
            width: 56px; height: 56px; border-radius: 50%;
            background: linear-gradient(135deg, var(--rose-main), var(--rose-dark));
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; flex-shrink: 0;
            box-shadow: 0 0 0 3px rgba(233,30,99,0.3), 0 4px 16px rgba(233,30,99,0.4);
            animation: pulse-ring 3s ease-in-out infinite;
        }
        @keyframes pulse-ring {
            0%,100% { box-shadow: 0 0 0 3px rgba(233,30,99,0.3), 0 4px 16px rgba(233,30,99,0.4); }
            50%      { box-shadow: 0 0 0 6px rgba(233,30,99,0.15), 0 4px 24px rgba(233,30,99,0.5); }
        }
        .user-strip-name { font-size: 1rem; font-weight: 700; color: #7B1340; }
        .user-strip-sub  { font-size: 0.8rem; color: rgba(176,96,128,0.7); margin-top: 0.2rem; direction: ltr; text-align: right; }

        /* ═══════════════════════════════════════
           PROGRESS PILLS
        ═══════════════════════════════════════ */
        .survey-progress {
            margin-bottom: 2rem;
        }
        .progress-meta {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 0.6rem;
        }
        .progress-label { font-size: 0.8rem; color: rgba(176,96,128,0.7); font-weight: 500; }
        .progress-count { font-size: 0.8rem; color: #C2185B; font-weight: 700; }
        .progress-track {
            height: 6px; border-radius: 3px;
            background: rgba(233,30,99,0.1);
            overflow: hidden;
        }
        .progress-fill {
            height: 100%; border-radius: 3px;
            background: linear-gradient(90deg, var(--rose-soft), var(--gold));
            width: 0%; transition: width 0.5s cubic-bezier(0.22,1,0.36,1);
            box-shadow: 0 0 8px rgba(233,30,99,0.5);
        }

        /* ═══════════════════════════════════════
           SECTION TITLE
        ═══════════════════════════════════════ */
        .questions-title {
            font-size: 0.85rem; font-weight: 700;
            color: rgba(176,96,128,0.8);
            text-transform: uppercase; letter-spacing: 2px;
            margin-bottom: 1.25rem;
            display: flex; align-items: center; gap: 0.75rem;
        }
        .questions-title::after {
            content: ''; flex: 1; height: 1px;
            background: linear-gradient(to left, transparent, rgba(233,30,99,0.25));
        }

        /* ═══════════════════════════════════════
           QUESTION CARDS
        ═══════════════════════════════════════ */
        .q-card {
            background: rgba(255,255,255,0.65);
            border: 1px solid rgba(233,30,99,0.1);
            border-radius: 1.5rem;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.35s ease;
            animation: slideUp var(--delay, 0.3s) cubic-bezier(0.22,1,0.36,1) both;
            position: relative;
            overflow: hidden;
        }
        .q-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(233,30,99,0.04) 0%, transparent 60%);
            opacity: 0;
            transition: opacity 0.35s;
        }
        .q-card.has-answer { border-color: rgba(233,30,99,0.3); background: rgba(255,240,245,0.8); }
        .q-card.has-answer::before { opacity: 1; }
        .q-card:hover { border-color: rgba(233,30,99,0.2); transform: translateX(-2px); box-shadow: 0 4px 20px rgba(233,30,99,0.08); }

        .q-header {
            display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 1.25rem;
        }
        .q-num {
            flex-shrink: 0;
            width: 32px; height: 32px; border-radius: 50%;
            background: linear-gradient(135deg, #E91E63, #C2185B);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.8rem; font-weight: 800; color: white;
            box-shadow: 0 2px 8px rgba(233,30,99,0.35);
        }
        .q-text {
            font-size: 0.975rem; font-weight: 600;
            color: #3D0020;
            line-height: 1.65; flex: 1; padding-top: 4px;
        }
        .q-answered-tag {
            flex-shrink: 0;
            font-size: 0.7rem; font-weight: 600;
            color: #2E7D32;
            background: rgba(46,125,50,0.08);
            border: 1px solid rgba(46,125,50,0.2);
            border-radius: 0.5rem; padding: 0.15rem 0.5rem;
            margin-top: 4px;
        }

        /* ═══════════════════════════════════════
           RADIO ANSWER OPTIONS
        ═══════════════════════════════════════ */
        .answer-list { display: flex; flex-direction: column; gap: 0.5rem; }

        .answer-radio { display: none; }

        .answer-opt {
            display: flex; align-items: center; gap: 0.85rem;
            padding: 0.8rem 1.1rem;
            border-radius: 1rem;
            border: 1.5px solid rgba(233,30,99,0.15);
            background: rgba(255,255,255,0.7);
            cursor: pointer;
            transition: all 0.25s ease;
            position: relative; overflow: hidden;
            user-select: none;
        }
        .answer-opt::before {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(252,228,236,0.8), rgba(248,187,208,0.4));
            opacity: 0; transition: opacity 0.25s;
        }
        .answer-opt:hover {
            border-color: rgba(233,30,99,0.35);
            transform: translateX(-3px);
            box-shadow: 0 2px 12px rgba(233,30,99,0.1);
        }
        .answer-opt:hover::before { opacity: 1; }

        /* Custom radio circle */
        .opt-circle {
            width: 20px; height: 20px; border-radius: 50%; flex-shrink: 0;
            border: 2px solid rgba(233,30,99,0.35);
            background: transparent;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.25s ease;
            position: relative;
        }
        .opt-circle::after {
            content: '';
            width: 8px; height: 8px; border-radius: 50%;
            background: var(--rose-main);
            opacity: 0; transform: scale(0);
            transition: all 0.25s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .opt-text {
            font-size: 0.875rem; font-weight: 500;
            color: #6D3B47;
            transition: all 0.25s ease; flex: 1;
        }

        /* Checked state */
        .answer-radio:checked + .answer-opt {
            border-color: var(--rose-main);
            background: linear-gradient(135deg, rgba(233,30,99,0.18), rgba(194,24,91,0.1));
            box-shadow: 0 4px 20px rgba(233,30,99,0.2), inset 0 1px 0 rgba(255,255,255,0.08);
            transform: translateX(-3px);
        }
        .answer-radio:checked + .answer-opt::before { opacity: 1; }
        .answer-radio:checked + .answer-opt .opt-circle {
            border-color: var(--rose-main);
            background: rgba(233,30,99,0.15);
            box-shadow: 0 0 12px rgba(233,30,99,0.4);
        }
        .answer-radio:checked + .answer-opt .opt-circle::after {
            opacity: 1; transform: scale(1);
        }
        .answer-radio:checked + .answer-opt .opt-text {
            color: rgba(255,230,240,0.95);
            font-weight: 600;
        }

        /* Bloom ripple on check */
        @keyframes bloom {
            0%   { transform: scale(0); opacity: 0.5; }
            100% { transform: scale(3); opacity: 0; }
        }
        .bloom-ripple {
            position: absolute; right: 1rem; top: 50%; transform: translateY(-50%);
            width: 16px; height: 16px; border-radius: 50%;
            background: rgba(233,30,99,0.4);
            pointer-events: none;
        }
        .answer-radio:checked + .answer-opt .bloom-ripple {
            animation: bloom 0.5s ease-out both;
        }

        /* ═══════════════════════════════════════
           SUBMIT AREA
        ═══════════════════════════════════════ */
        .submit-section {
            margin-top: 2rem; padding-top: 1.75rem;
            border-top: 1px solid rgba(233,30,99,0.1);
            display: flex; flex-direction: column; align-items: center; gap: 1rem;
        }
        .submit-section .btn-rose {
            width: 100%; justify-content: center;
            padding: 1.1rem; font-size: 1.05rem;
            border-radius: 1.25rem;
        }
        .submit-hint {
            font-size: 0.775rem; color: rgba(176,96,128,0.55); text-align: center;
        }

        /* ═══════════════════════════════════════
           FOOTER
        ═══════════════════════════════════════ */
        .footer-note {
            text-align: center; margin-top: 2rem;
            color: rgba(176,96,128,0.5); font-size: 0.78rem;
            letter-spacing: 0.5px; animation: heroIn 1s ease 0.5s both;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ═══════════════════════════════════════
           EMPTY STATE
        ═══════════════════════════════════════ */
        .empty-state {
            text-align: center; padding: 3rem 1rem;
            color: rgba(176,96,128,0.5);
        }
        .empty-state .empty-icon { font-size: 3rem; margin-bottom: 1rem; display: block; animation: float 4s ease-in-out infinite; }

        /* ═══════════════════════════════════════
           RESPONSIVE
        ═══════════════════════════════════════ */
        @media (max-width: 480px) {
            .card-inner { padding: 1.75rem 1.25rem; }
            .brand-name { font-size: 1.8rem; }
            .input-row { flex-direction: column; }
            .hero { margin-bottom: 2rem; }
            .page-wrap { padding: 3rem 0.75rem 2rem; }
        }
    </style>
</head>
<body>

    <!-- ════ BACKGROUND SCENE ════ -->
    <div class="bg-scene">
        <div class="bg-gradient"></div>

        <!-- Bokeh -->
        <div class="bokeh bokeh-1"></div>
        <div class="bokeh bokeh-2"></div>
        <div class="bokeh bokeh-3"></div>
        <div class="bokeh bokeh-4"></div>
        <div class="bokeh bokeh-5"></div>

        <!-- Sparkles -->
        <div class="sparkle" style="top:15%;left:10%;--d:2.5s;--delay:0s;"></div>
        <div class="sparkle" style="top:30%;left:85%;--d:3.5s;--delay:1s;"></div>
        <div class="sparkle" style="top:55%;left:5%;--d:2s;--delay:0.5s;"></div>
        <div class="sparkle" style="top:70%;left:92%;--d:4s;--delay:1.5s;"></div>
        <div class="sparkle" style="top:80%;left:20%;--d:3s;--delay:2s;"></div>
        <div class="sparkle" style="top:20%;left:70%;--d:2.8s;--delay:0.8s;"></div>
        <div class="sparkle" style="top:45%;left:50%;--d:3.2s;--delay:1.2s;"></div>
        <div class="sparkle" style="top:90%;left:60%;--d:2.2s;--delay:0.3s;"></div>
        <div class="sparkle" style="top:10%;left:40%;--d:3.8s;--delay:2.5s;"></div>

        <!-- Petal rain -->
        <div class="petal-layer" id="petalLayer"></div>
    </div>

    <!-- Large decorative flowers -->
    <div class="deco-flower br">
        <svg width="400" height="400" viewBox="0 0 400 400" fill="none">
            <g transform="translate(200,200)">
                <ellipse cx="0" cy="-80" rx="35" ry="70" fill="#F48FB1"/>
                <ellipse cx="0" cy="-80" rx="35" ry="70" fill="#F48FB1" transform="rotate(45)"/>
                <ellipse cx="0" cy="-80" rx="35" ry="70" fill="#F06292" transform="rotate(90)"/>
                <ellipse cx="0" cy="-80" rx="35" ry="70" fill="#F06292" transform="rotate(135)"/>
                <ellipse cx="0" cy="-80" rx="35" ry="70" fill="#F48FB1" transform="rotate(180)"/>
                <ellipse cx="0" cy="-80" rx="35" ry="70" fill="#F48FB1" transform="rotate(225)"/>
                <ellipse cx="0" cy="-80" rx="35" ry="70" fill="#F06292" transform="rotate(270)"/>
                <ellipse cx="0" cy="-80" rx="35" ry="70" fill="#F06292" transform="rotate(315)"/>
                <circle cx="0" cy="0" r="40" fill="#FFCDD2"/>
                <circle cx="0" cy="0" r="22" fill="#FFF0F5"/>
            </g>
        </svg>
    </div>
    <div class="deco-flower tl">
        <svg width="320" height="320" viewBox="0 0 320 320" fill="none">
            <g transform="translate(160,160)">
                <ellipse cx="0" cy="-60" rx="25" ry="55" fill="#F8BBD0"/>
                <ellipse cx="0" cy="-60" rx="25" ry="55" fill="#F8BBD0" transform="rotate(60)"/>
                <ellipse cx="0" cy="-60" rx="25" ry="55" fill="#F48FB1" transform="rotate(120)"/>
                <ellipse cx="0" cy="-60" rx="25" ry="55" fill="#F48FB1" transform="rotate(180)"/>
                <ellipse cx="0" cy="-60" rx="25" ry="55" fill="#F8BBD0" transform="rotate(240)"/>
                <ellipse cx="0" cy="-60" rx="25" ry="55" fill="#F8BBD0" transform="rotate(300)"/>
                <circle cx="0" cy="0" r="30" fill="#FFE4EE"/>
                <circle cx="0" cy="0" r="16" fill="#FFF0F5"/>
            </g>
        </svg>
    </div>

    <!-- Progress bar -->
    <div class="progress-bar-wrap">
        <div class="progress-bar-fill" id="scrollProgress"></div>
    </div>

    <!-- PAGE -->
    <div class="page-wrap">

        <!-- Hero -->
        <div class="hero">
            <div class="hero-flower">
                <svg width="100" height="100" viewBox="0 0 100 100" fill="none">
                    <defs>
                        <radialGradient id="petalGrad" cx="50%" cy="30%">
                            <stop offset="0%" stop-color="#FF80AB"/>
                            <stop offset="100%" stop-color="#C2185B"/>
                        </radialGradient>
                        <radialGradient id="centerGrad" cx="50%" cy="40%">
                            <stop offset="0%" stop-color="#FFF9C4"/>
                            <stop offset="100%" stop-color="#F9A825"/>
                        </radialGradient>
                    </defs>
                    <!-- 8 petals -->
                    <ellipse cx="50" cy="18" rx="11" ry="22" fill="url(#petalGrad)" opacity="0.95"/>
                    <ellipse cx="50" cy="18" rx="11" ry="22" fill="url(#petalGrad)" opacity="0.9"  transform="rotate(45  50 50)"/>
                    <ellipse cx="50" cy="18" rx="11" ry="22" fill="url(#petalGrad)" opacity="0.85" transform="rotate(90  50 50)"/>
                    <ellipse cx="50" cy="18" rx="11" ry="22" fill="url(#petalGrad)" opacity="0.9"  transform="rotate(135 50 50)"/>
                    <ellipse cx="50" cy="18" rx="11" ry="22" fill="url(#petalGrad)" opacity="0.95" transform="rotate(180 50 50)"/>
                    <ellipse cx="50" cy="18" rx="11" ry="22" fill="url(#petalGrad)" opacity="0.9"  transform="rotate(225 50 50)"/>
                    <ellipse cx="50" cy="18" rx="11" ry="22" fill="url(#petalGrad)" opacity="0.85" transform="rotate(270 50 50)"/>
                    <ellipse cx="50" cy="18" rx="11" ry="22" fill="url(#petalGrad)" opacity="0.9"  transform="rotate(315 50 50)"/>
                    <!-- Center -->
                    <circle cx="50" cy="50" r="17" fill="url(#centerGrad)"/>
                    <circle cx="50" cy="50" r="9"  fill="#F9A825" opacity="0.7"/>
                    <!-- Pollen dots -->
                    <circle cx="50" cy="42" r="2" fill="#7B1340" opacity="0.5"/>
                    <circle cx="57" cy="47" r="2" fill="#7B1340" opacity="0.5"/>
                    <circle cx="43" cy="47" r="2" fill="#7B1340" opacity="0.5"/>
                    <circle cx="54" cy="55" r="2" fill="#7B1340" opacity="0.5"/>
                    <circle cx="46" cy="55" r="2" fill="#7B1340" opacity="0.5"/>
                </svg>
            </div>
            <h1 class="brand-name">گلفروشی فلورین</h1>
            <p class="brand-tagline">✦ &nbsp; ارسال گل با محبت &nbsp; ✦</p>
        </div>

        <!-- Card -->
        <div class="card">
            <div class="card-inner">

                @if(session('success'))
                <div class="success-box">
                    <p>🌸 {{ session('success') }}</p>
                </div>
                @endif

                @if(!isset($user) && !isset($notFound))
                {{-- ════ PHONE FORM ════ --}}
                <div class="section-divider">شماره موبایل خود را وارد کنید</div>

                <form method="POST" action="{{ route('survey.lookup') }}">
                    @csrf
                    <label class="form-label" for="phone">
                        📱 &nbsp; شماره موبایل
                    </label>
                    <div class="input-row">
                        <input
                            type="tel" id="phone" name="phone"
                            class="phone-input"
                            placeholder="۰۹۱۲۳۴۵۶۷۸۹"
                            value="{{ old('phone') }}"
                            autocomplete="off" maxlength="11"
                            autofocus
                        >
                        <button type="submit" class="btn-rose">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                            </svg>
                            جستجو
                        </button>
                    </div>
                    @error('phone')
                        <p class="error-msg">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </form>

                @elseif(isset($notFound) && $notFound)
                {{-- ════ NOT FOUND ════ --}}
                <div class="not-found-box">
                    <span class="not-found-icon">🥀</span>
                    <h3>شماره در سیستم ثبت نشده</h3>
                    <p>
                        شماره &nbsp;<strong style="direction:ltr;display:inline-block;font-family:monospace;color:#FF8A80;">{{ $phone }}</strong>&nbsp;
                        در پایگاه داده ما یافت نشد.<br>
                        لطفاً شماره صحیح خود را وارد کنید.
                    </p>
                </div>

                <div class="section-divider" style="margin-top:1.75rem;">تلاش مجدد</div>
                <form method="POST" action="{{ route('survey.lookup') }}">
                    @csrf
                    <div class="input-row">
                        <input type="tel" name="phone" class="phone-input"
                            placeholder="۰۹۱۲۳۴۵۶۷۸۹"
                            value="{{ $phone }}" autocomplete="off" maxlength="11" autofocus>
                        <button type="submit" class="btn-rose">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                            </svg>
                            جستجو
                        </button>
                    </div>
                </form>

                @elseif(isset($user))
                {{-- ════ SURVEY FORM ════ --}}

                <!-- User greeting -->
                <div class="user-strip">
                    <div class="user-avatar-ring">🌹</div>
                    <div style="flex:1; min-width:0;">
                        <div class="user-strip-name">خوش آمدید، {{ $user->getName() }}</div>
                        <div class="user-strip-sub">{{ $phone }}</div>
                    </div>
                    @if(isset($previousAnswers) && $previousAnswers->count() > 0)
                    <div style="flex-shrink:0;text-align:center;">
                        <div style="font-size:1.25rem;font-weight:800;color:rgba(144,238,144,0.9);">{{ $previousAnswers->count() }}</div>
                        <div style="font-size:0.65rem;color:rgba(144,238,144,0.55);">پاسخ قبلی</div>
                    </div>
                    @endif
                </div>

                @if($questions->isEmpty())
                <div class="empty-state">
                    <span class="empty-icon">🌺</span>
                    <p>در حال حاضر سوالی برای نظرسنجی وجود ندارد.</p>
                </div>

                @else

                <!-- Progress -->
                <div class="survey-progress" id="surveyProgress">
                    <div class="progress-meta">
                        <span class="progress-label">پیشرفت نظرسنجی</span>
                        <span class="progress-count" id="progressText">۰ از {{ $questions->count() }}</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" id="progressFill"></div>
                    </div>
                </div>

                <!-- Questions -->
                <div class="questions-title">🌸 &nbsp;سوالات نظرسنجی</div>

                <form method="POST" action="{{ route('survey.submit') }}" id="surveyForm">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">

                    @foreach($questions as $index => $question)
                    @php
                        $prevAns = $previousAnswers[$question->id] ?? null;
                        $delayMs = 300 + $index * 80;
                    @endphp
                    <div class="q-card {{ $prevAns ? 'has-answer' : '' }}" style="--delay:{{ $delayMs }}ms;" data-q="{{ $question->id }}">
                        <div class="q-header">
                            <span class="q-num">{{ $index + 1 }}</span>
                            <span class="q-text">{{ $question->question }}</span>
                            @if($prevAns)
                                <span class="q-answered-tag">✓ پاسخ داده شده</span>
                            @endif
                        </div>

                        @if($question->answers->isNotEmpty())
                        <div class="answer-list">
                            @foreach($question->answers as $answer)
                            @php $checked = $prevAns && $prevAns->answer_id === $answer->id; @endphp
                            <input
                                type="radio"
                                class="answer-radio"
                                id="q{{ $question->id }}_a{{ $answer->id }}"
                                name="answers[{{ $question->id }}]"
                                value="{{ $answer->id }}"
                                {{ $checked ? 'checked' : '' }}
                                data-question="{{ $question->id }}"
                            >
                            <label class="answer-opt" for="q{{ $question->id }}_a{{ $answer->id }}">
                                <span class="opt-circle"></span>
                                <span class="opt-text">{{ $answer->answer }}</span>
                                <span class="bloom-ripple"></span>
                            </label>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endforeach

                    @error('answers')
                        <p class="error-msg" style="margin-bottom:1rem;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </p>
                    @enderror

                    <div class="submit-section">
                        <button type="submit" class="btn-rose" id="submitBtn">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M20 6L9 17l-5-5"/>
                            </svg>
                            ثبت نظرسنجی
                        </button>
                        <p class="submit-hint">نظر شما برای بهبود خدمات ما ارزشمند است 🌹</p>
                    </div>
                </form>

                <div style="text-align:center;margin-top:1.25rem;">
                    <a href="{{ route('survey.index') }}" class="btn-ghost">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                        بازگشت
                    </a>
                </div>
                @endif
                @endif

            </div><!-- /.card-inner -->
        </div><!-- /.card -->

        <p class="footer-note">🌹 &nbsp; گلفروشی فلورین &nbsp;|&nbsp; هر روز تازه‌ترین گل‌ها برای شما &nbsp; 🌸</p>

    </div><!-- /.page-wrap -->

    <script>
    (function () {
        /* ── Petal rain ── */
        const layer = document.getElementById('petalLayer');
        const colors = ['#F48FB1','#F06292','#EC407A','#E91E63','#F8BBD0','#CE93D8','#FFCDD2','#FCE4EC'];
        const petalPaths = [
            // Simple ellipse petal
            (c) => `<svg viewBox="0 0 40 60"><ellipse cx="20" cy="30" rx="14" ry="28" fill="${c}" opacity="0.85"/></svg>`,
            // Pointed petal
            (c) => `<svg viewBox="0 0 40 60"><path d="M20 0 Q38 20 20 58 Q2 20 20 0Z" fill="${c}" opacity="0.8"/></svg>`,
            // Round petal
            (c) => `<svg viewBox="0 0 50 50"><ellipse cx="25" cy="25" rx="20" ry="22" fill="${c}" opacity="0.75"/></svg>`,
            // Heart petal
            (c) => `<svg viewBox="0 0 40 40"><path d="M20 35 C20 35 4 22 4 13 C4 7 9 3 14 5 C17 6 20 10 20 10 C20 10 23 6 26 5 C31 3 36 7 36 13 C36 22 20 35 20 35Z" fill="${c}" opacity="0.8"/></svg>`,
        ];

        function makePetal() {
            const div = document.createElement('div');
            div.className = 'petal';
            const size = 12 + Math.random() * 20;
            const left = Math.random() * 100;
            const dur  = 7 + Math.random() * 10;
            const delay= Math.random() * 15;
            const dx   = (Math.random() - 0.5) * 120;
            const r0   = Math.random() * 360;
            const r1   = r0 + 180 + Math.random() * 360;
            const op   = 0.4 + Math.random() * 0.5;
            const color = colors[Math.floor(Math.random() * colors.length)];
            const template = petalPaths[Math.floor(Math.random() * petalPaths.length)];
            div.style.cssText = `
                left:${left}%;
                width:${size}px; height:${size}px;
                --dur:${dur}s; --delay:${delay}s;
                --dx:${dx}px; --r0:${r0}deg; --r1:${r1}deg; --op:${op};
                animation-delay:${delay}s;
            `;
            div.innerHTML = template(color);
            layer.appendChild(div);
        }
        for (let i = 0; i < 28; i++) makePetal();

        /* ── Scroll progress bar ── */
        const fill = document.getElementById('scrollProgress');
        window.addEventListener('scroll', () => {
            const total = document.body.scrollHeight - window.innerHeight;
            fill.style.width = total > 0 ? (window.scrollY / total * 100) + '%' : '0%';
        }, { passive: true });

        /* ── Survey answer progress ── */
        const form = document.getElementById('surveyForm');
        if (form) {
            const totalQ = {{ isset($questions) ? $questions->count() : 0 }};
            const progressFill = document.getElementById('progressFill');
            const progressText = document.getElementById('progressText');
            const toFarsi = n => n.toString().replace(/\d/g, d => '۰۱۲۳۴۵۶۷۸۹'[d]);

            function updateProgress() {
                const answered = new Set();
                form.querySelectorAll('.answer-radio:checked').forEach(r => {
                    answered.add(r.dataset.question);
                });
                const pct = totalQ > 0 ? (answered.size / totalQ * 100) : 0;
                if (progressFill) progressFill.style.width = pct + '%';
                if (progressText) progressText.textContent = toFarsi(answered.size) + ' از ' + toFarsi(totalQ);

                // Update card state
                answered.forEach(qid => {
                    const card = document.querySelector(`.q-card[data-q="${qid}"]`);
                    if (card) card.classList.add('has-answer');
                });
            }

            form.addEventListener('change', updateProgress);
            updateProgress(); // init with pre-selected

            /* Prevent double submit */
            form.addEventListener('submit', () => {
                const btn = document.getElementById('submitBtn');
                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML = `
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                             style="animation:btnSpin 0.8s linear infinite">
                            <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4"/>
                        </svg>
                        در حال ثبت…
                    `;
                }
            });
        }

        /* inline spin keyframe */
        const s = document.createElement('style');
        s.textContent = '@keyframes btnSpin{to{transform:rotate(360deg)}}';
        document.head.appendChild(s);

    })();
    </script>

</body>
</html>
