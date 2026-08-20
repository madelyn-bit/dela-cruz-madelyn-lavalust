<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOVA-CRED // Student Access Terminal</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700;900&family=Space+Grotesk:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        :root{
            --void-950:#05010f;
            --void-900:#0f0620;
            --pink-500:#ff2d9a;
            --pink-400:#ff6fc6;
            --pink-300:#ffa8dc;
            --violet-500:#a855f7;
            --text-hi:#fdf2fb;
            --text-mu:#c9b6d9;
        }

        *{box-sizing:border-box;}

        body{
            margin:0;
            min-height:100vh;
            background:
                radial-gradient(ellipse 90% 60% at 15% -10%, rgba(255,45,154,0.28), transparent 60%),
                radial-gradient(ellipse 80% 60% at 100% 0%, rgba(168,85,247,0.22), transparent 55%),
                radial-gradient(ellipse 60% 50% at 50% 110%, rgba(255,111,198,0.15), transparent 60%),
                var(--void-950);
            color:var(--text-hi);
            font-family:'Space Grotesk', sans-serif;
            position:relative;
            overflow-x:hidden;
        }

        .font-display{ font-family:'Orbitron', sans-serif; }
        .font-mono{ font-family:'JetBrains Mono', monospace; }

        .grid-field{
            position:fixed;
            inset:0;
            background-image:
                linear-gradient(rgba(255,111,198,0.07) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,111,198,0.07) 1px, transparent 1px);
            background-size:48px 48px;
            mask-image:radial-gradient(ellipse 70% 70% at 50% 20%, black 20%, transparent 75%);
            pointer-events:none;
            z-index:0;
        }

        .orb{
            position:fixed;
            border-radius:9999px;
            filter:blur(70px);
            pointer-events:none;
            z-index:0;
            opacity:0.5;
        }
        .orb-1{ width:380px; height:380px; top:-140px; left:-100px; background:var(--pink-500); animation:float-a 14s ease-in-out infinite; }
        .orb-2{ width:340px; height:340px; bottom:-120px; right:-100px; background:var(--violet-500); animation:float-b 17s ease-in-out infinite; }

        @keyframes float-a{ 0%,100%{ transform:translate(0,0) scale(1); } 50%{ transform:translate(30px,-25px) scale(1.08); } }
        @keyframes float-b{ 0%,100%{ transform:translate(0,0) scale(1); } 50%{ transform:translate(-25px,20px) scale(1.05); } }

        .glass{
            background:linear-gradient(160deg, rgba(255,255,255,0.07), rgba(255,255,255,0.02));
            border:1px solid rgba(255,111,198,0.22);
            backdrop-filter:blur(18px);
            -webkit-backdrop-filter:blur(18px);
            box-shadow:0 8px 32px rgba(5,1,15,0.45), inset 0 1px 0 rgba(255,255,255,0.06);
        }

        .halo-border{ position:relative; }
        .halo-border::before{
            content:'';
            position:absolute;
            inset:-1.5px;
            border-radius:inherit;
            padding:1.5px;
            background:conic-gradient(from var(--angle,0deg), var(--pink-500), var(--violet-500), var(--pink-300), var(--pink-500));
            -webkit-mask:linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
            -webkit-mask-composite:xor;
            mask-composite:exclude;
            animation:spin-border 6s linear infinite;
            z-index:-1;
        }
        @property --angle{ syntax:'<angle>'; initial-value:0deg; inherits:false; }
        @keyframes spin-border{ to{ --angle:360deg; } }

        /* scanning sweep line across the ID card */
        .scan-line{
            position:absolute;
            left:0; right:0; height:2px;
            background:linear-gradient(90deg, transparent, rgba(255,111,198,0.9), transparent);
            filter:blur(0.5px);
            animation:scan-move 3.4s ease-in-out infinite;
            z-index:1;
            border-radius:9999px;
        }
        @keyframes scan-move{
            0%{ top:6%; opacity:0; }
            10%{ opacity:1; }
            50%{ top:94%; opacity:1; }
            60%{ opacity:0; }
            100%{ top:94%; opacity:0; }
        }

        .badge-ring{
            position:relative;
        }
        .badge-ring::before{
            content:'';
            position:absolute;
            inset:-6px;
            border-radius:9999px;
            border:1.5px dashed rgba(255,111,198,0.45);
            animation:spin-slow 12s linear infinite;
        }
        @keyframes spin-slow{ to{ transform:rotate(360deg); } }

        .pulse-dot{ animation:pulse-glow 2.2s ease-in-out infinite; }
        @keyframes pulse-glow{
            0%,100%{ box-shadow:0 0 0 0 rgba(255,45,154,0.55); }
            50%{ box-shadow:0 0 0 8px rgba(255,45,154,0); }
        }

        .glow-text{ text-shadow:0 0 18px rgba(255,111,198,0.55), 0 0 40px rgba(168,85,247,0.25); }

        .field-row{
            transition:background .2s ease, transform .2s ease;
            border-radius:0.75rem;
        }
        .field-row:hover{
            background:rgba(255,111,198,0.06);
            transform:translateX(2px);
        }

        .fade-up{ animation:fadeUp .8s cubic-bezier(.2,.7,.2,1) both; }
        @keyframes fadeUp{ from{ opacity:0; transform:translateY(18px);} to{ opacity:1; transform:translateY(0);} }
        .delay-1{ animation-delay:.1s; }
        .delay-2{ animation-delay:.22s; }
        .delay-3{ animation-delay:.34s; }

        @media (prefers-reduced-motion: reduce){
            *{ animation-duration:0.001ms !important; animation-iteration-count:1 !important; transition-duration:0.001ms !important; }
        }
    </style>
</head>
<body class="antialiased">

    <div class="grid-field"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>

    <div class="relative z-10 min-h-screen flex flex-col">

        <nav aria-label="Main navigation" class="w-full">
            <div class="max-w-3xl mx-auto px-6 pt-8 flex items-center justify-between fade-up">
                <div class="flex items-center gap-2 font-display font-bold tracking-widest text-sm text-[var(--pink-300)]">
                    <span class="inline-block w-2 h-2 rounded-full bg-[var(--pink-500)] pulse-dot"></span>
                    NOVA&#8209;CRED
                </div>
                <div class="flex items-center gap-6 font-mono text-xs sm:text-sm text-[var(--text-mu)]">
                    <a href="<?= site_url('student'); ?>" class="hover:text-[var(--pink-300)] transition-colors">HOME</a>
                    <span class="opacity-30">/</span>
                    <a href="<?= site_url('student/profile'); ?>" class="hover:text-[var(--pink-300)] transition-colors">STUDENT_PROFILE</a>
                </div>
            </div>
        </nav>

        <main class="flex-1 px-6 py-12">
            <div class="max-w-3xl mx-auto">

                <div class="fade-up delay-1 mb-6">
                    <p class="font-mono text-xs tracking-[0.3em] text-[var(--pink-400)] mb-2">SECURE RECORD &middot; MCC CAMPUS NETWORK</p>
                    <h1 class="font-display text-3xl sm:text-4xl font-900 glow-text">Student Information</h1>
                </div>

                <!-- ID card -->
                <div class="halo-border rounded-3xl fade-up delay-2">
                    <div class="glass relative overflow-hidden rounded-3xl p-6 sm:p-8">
                        <div class="scan-line"></div>

                        <div class="flex flex-wrap items-center gap-5 pb-6 mb-6 border-b border-white/10">
                            <div class="badge-ring">
                                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-[var(--pink-500)] via-[var(--pink-400)] to-[var(--violet-500)] flex items-center justify-center font-display font-bold text-2xl shadow-lg shadow-pink-500/30">
                                    <?= htmlspecialchars($avatar_initials) ?>
                                </div>
                            </div>
                            <div class="flex-1 min-w-[200px]">
                                <p class="font-display font-bold text-xl sm:text-2xl leading-tight"><?= htmlspecialchars($name) ?></p>
                                <p class="font-mono text-sm text-[var(--pink-300)] mt-1"><?= htmlspecialchars($student_id) ?></p>
                            </div>
                            <span class="inline-flex items-center gap-2 font-mono text-xs px-3 py-1.5 rounded-full bg-emerald-400/10 border border-emerald-300/30 text-emerald-300">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 pulse-dot"></span>
                                <?= htmlspecialchars($status) ?>
                            </span>
                        </div>

                        <dl class="grid sm:grid-cols-2 gap-x-6 gap-y-1">
                            <div class="field-row px-3 py-3">
                                <dt class="font-mono text-[10px] tracking-[0.2em] text-[var(--text-mu)] mb-1">COURSE</dt>
                                <dd class="m-0 font-medium"><?= htmlspecialchars($course) ?></dd>
                            </div>
                            <div class="field-row px-3 py-3">
                                <dt class="font-mono text-[10px] tracking-[0.2em] text-[var(--text-mu)] mb-1">YEAR LEVEL</dt>
                                <dd class="m-0 font-medium"><?= htmlspecialchars($year) ?></dd>
                            </div>
                            <div class="field-row px-3 py-3">
                                <dt class="font-mono text-[10px] tracking-[0.2em] text-[var(--text-mu)] mb-1">SECTION</dt>
                                <dd class="m-0 font-medium"><?= htmlspecialchars($section) ?></dd>
                            </div>
                            <div class="field-row px-3 py-3">
                                <dt class="font-mono text-[10px] tracking-[0.2em] text-[var(--text-mu)] mb-1">CONTACT NO.</dt>
                                <dd class="m-0 font-medium"><?= htmlspecialchars($contact) ?></dd>
                            </div>
                            <div class="field-row px-3 py-3">
                                <dt class="font-mono text-[10px] tracking-[0.2em] text-[var(--text-mu)] mb-1">EMAIL</dt>
                                <dd class="m-0 font-medium break-all"><?= htmlspecialchars($email) ?></dd>
                            </div>
                            <div class="field-row px-3 py-3">
                                <dt class="font-mono text-[10px] tracking-[0.2em] text-[var(--text-mu)] mb-1">ADDRESS</dt>
                                <dd class="m-0 font-medium"><?= htmlspecialchars($address) ?></dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- extra profile / about panel -->
                <div class="halo-border rounded-3xl fade-up delay-3 mt-8">
                    <div class="glass rounded-3xl p-6 sm:p-8">
                        <p class="font-mono text-xs tracking-[0.3em] text-[var(--pink-400)] mb-5">ABOUT &middot; NODE PROFILE</p>

                        <div class="grid sm:grid-cols-2 gap-x-6 gap-y-4 font-mono text-sm">
                            <div>
                                <p class="text-[var(--text-mu)] text-[10px] tracking-[0.2em] mb-1">NICKNAME</p>
                                <p class="text-[var(--text-hi)]">Nag-Iba 1</p>
                            </div>
                            <div>
                                <p class="text-[var(--text-mu)] text-[10px] tracking-[0.2em] mb-1">ROLE</p>
                                <p class="text-[var(--text-hi)]">BSIT Student</p>
                            </div>
                            <div>
                                <p class="text-[var(--text-mu)] text-[10px] tracking-[0.2em] mb-1">STRENGTH</p>
                                <p class="text-[var(--text-hi)]">Adaptability</p>
                            </div>
                            <div>
                                <p class="text-[var(--text-mu)] text-[10px] tracking-[0.2em] mb-1">HOBBY</p>
                                <p class="text-[var(--text-hi)]">Watching movies</p>
                            </div>
                        </div>

                        <div class="mt-6 pt-5 border-t border-white/10 flex flex-wrap items-center gap-4">
                            <a href="https://www.facebook.com/profile.php?id=61578792653539" target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center gap-2 font-mono text-xs px-4 py-2 rounded-full bg-gradient-to-r from-[var(--pink-500)]/20 to-[var(--violet-500)]/20 border border-[var(--pink-400)]/40 hover:border-[var(--pink-300)] transition-colors">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" class="text-[var(--pink-300)]"><path d="M22 12.06C22 6.5 17.52 2 12 2S2 6.5 2 12.06c0 5 3.66 9.15 8.44 9.94v-7.03H7.9v-2.9h2.54V9.85c0-2.5 1.49-3.89 3.77-3.89 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56v1.88h2.78l-.44 2.9h-2.34V22c4.78-.79 8.44-4.94 8.44-9.94Z"/></svg>
                                Facebook Profile
                            </a>
                            <span class="font-mono text-[11px] text-[var(--text-mu)]">Reach node via contact no. above</span>
                        </div>
                    </div>
                </div>

            </div>
        </main>

        <footer class="w-full border-t border-white/5 py-5">
            <p class="text-center font-mono text-[11px] tracking-widest text-[var(--text-mu)]">
                NOVA&#8209;CRED ACCESS TERMINAL &middot; BSIT STUDENT NETWORK
            </p>
        </footer>

    </div>

</body>
</html>