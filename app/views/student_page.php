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
            --void-800:#170a2e;
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

        /* ambient grid backdrop */
        .grid-field{
            position:fixed;
            inset:0;
            background-image:
                linear-gradient(rgba(255,111,198,0.07) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,111,198,0.07) 1px, transparent 1px);
            background-size:48px 48px;
            mask-image:radial-gradient(ellipse 70% 70% at 50% 30%, black 20%, transparent 75%);
            pointer-events:none;
            z-index:0;
        }

        .orb{
            position:fixed;
            border-radius:9999px;
            filter:blur(70px);
            pointer-events:none;
            z-index:0;
            opacity:0.55;
        }
        .orb-1{ width:380px; height:380px; top:-120px; left:-100px; background:var(--pink-500); animation:float-a 14s ease-in-out infinite; }
        .orb-2{ width:320px; height:320px; bottom:-100px; right:-80px; background:var(--violet-500); animation:float-b 17s ease-in-out infinite; }
        .orb-3{ width:220px; height:220px; top:40%; left:60%; background:var(--pink-300); animation:float-a 11s ease-in-out infinite reverse; opacity:0.35; }

        @keyframes float-a{
            0%,100%{ transform:translate(0,0) scale(1); }
            50%{ transform:translate(30px,-25px) scale(1.08); }
        }
        @keyframes float-b{
            0%,100%{ transform:translate(0,0) scale(1); }
            50%{ transform:translate(-25px,20px) scale(1.05); }
        }

        /* glass panel */
        .glass{
            background:linear-gradient(160deg, rgba(255,255,255,0.07), rgba(255,255,255,0.02));
            border:1px solid rgba(255,111,198,0.25);
            backdrop-filter:blur(18px);
            -webkit-backdrop-filter:blur(18px);
            box-shadow:0 8px 32px rgba(5,1,15,0.45), inset 0 1px 0 rgba(255,255,255,0.06);
        }

        /* animated gradient border ring */
        .halo-border{
            position:relative;
        }
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
        @property --angle{
            syntax:'<angle>';
            initial-value:0deg;
            inherits:false;
        }
        @keyframes spin-border{
            to{ --angle:360deg; }
        }

        .pulse-dot{
            animation:pulse-glow 2.2s ease-in-out infinite;
        }
        @keyframes pulse-glow{
            0%,100%{ box-shadow:0 0 0 0 rgba(255,45,154,0.55); }
            50%{ box-shadow:0 0 0 8px rgba(255,45,154,0); }
        }

        .glow-text{
            text-shadow:0 0 18px rgba(255,111,198,0.55), 0 0 40px rgba(168,85,247,0.25);
        }

        .cta-btn{
            position:relative;
            overflow:hidden;
            transition:transform .25s ease, box-shadow .25s ease;
        }
        .cta-btn:hover{
            transform:translateY(-2px);
            box-shadow:0 10px 30px rgba(255,45,154,0.35);
        }
        .cta-btn::after{
            content:'';
            position:absolute;
            top:0; left:-60%;
            width:40%; height:100%;
            background:linear-gradient(120deg, transparent, rgba(255,255,255,0.35), transparent);
            transform:skewX(-20deg);
            transition:left .6s ease;
        }
        .cta-btn:hover::after{ left:130%; }

        .fade-up{
            animation:fadeUp .8s cubic-bezier(.2,.7,.2,1) both;
        }
        @keyframes fadeUp{
            from{ opacity:0; transform:translateY(18px); }
            to{ opacity:1; transform:translateY(0); }
        }
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
    <div class="orb orb-3"></div>

    <div class="relative z-10 min-h-screen flex flex-col">

        <nav aria-label="Main navigation" class="w-full">
            <div class="max-w-5xl mx-auto px-6 pt-8 flex items-center justify-between fade-up">
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

        <main class="flex-1 flex items-center">
            <div class="max-w-5xl mx-auto px-6 py-16 w-full grid md:grid-cols-[1.1fr,0.9fr] gap-12 items-center">

                <div class="fade-up delay-1">
                    <p class="font-mono text-xs tracking-[0.3em] text-[var(--pink-400)] mb-4">ACCESS TERMINAL &middot; MCC CAMPUS NETWORK</p>
                    <h1 class="font-display text-4xl sm:text-5xl font-900 leading-tight glow-text">
                        Welcome to the<br>
                        <span class="bg-gradient-to-r from-[var(--pink-400)] via-[var(--pink-300)] to-[var(--violet-500)] bg-clip-text text-transparent">Student Page</span>
                    </h1>
                    <p class="mt-5 text-[var(--text-mu)] leading-relaxed max-w-md">
                        Welcome to the Student Page. This is a sample page for students &mdash; your gateway into the NOVA&#8209;CRED access node for verified student credentials.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-4">
                        <a href="<?= site_url('student/profile'); ?>" class="cta-btn inline-flex items-center gap-2 font-mono text-sm font-medium px-6 py-3 rounded-full bg-gradient-to-r from-[var(--pink-500)] to-[var(--violet-500)] text-white shadow-lg shadow-pink-500/20">
                            OPEN STUDENT PROFILE
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                        </a>
                    </div>
                </div>

                <div class="fade-up delay-2">
                    <div class="halo-border rounded-3xl">
                        <div class="glass rounded-3xl p-6 sm:p-7">
                            <div class="flex items-center justify-between mb-5">
                                <span class="font-mono text-[10px] tracking-[0.25em] text-[var(--text-mu)]">ID PREVIEW</span>
                                <span class="flex items-center gap-1.5 font-mono text-[10px] text-[var(--pink-300)]">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[var(--pink-400)] pulse-dot"></span> LINKED
                                </span>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="relative w-16 h-16 shrink-0 rounded-2xl bg-gradient-to-br from-[var(--pink-500)] to-[var(--violet-500)] flex items-center justify-center font-display font-bold text-lg">
                                    MD
                                </div>
                                <div>
                                    <p class="font-display font-bold text-lg leading-tight">Madelyn L. Dela Cruz</p>
                                    <p class="font-mono text-xs text-[var(--pink-300)] mt-1">MCC2024&#8209;00022</p>
                                </div>
                            </div>

                            <div class="mt-6 pt-5 border-t border-white/10 grid grid-cols-2 gap-4 font-mono text-xs">
                                <div>
                                    <p class="text-[var(--text-mu)] mb-1">COURSE / SECTION</p>
                                    <p class="text-[var(--text-hi)] font-medium">BSIT F1</p>
                                </div>
                                <div>
                                    <p class="text-[var(--text-mu)] mb-1">STATUS</p>
                                    <p class="text-emerald-300 font-medium">Session Ready</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>

        <footer class="w-full border-t border-white/5 py-5 fade-up delay-3">
            <p class="text-center font-mono text-[11px] tracking-widest text-[var(--text-mu)]">
                NOVA&#8209;CRED ACCESS TERMINAL &middot; BSIT STUDENT NETWORK
            </p>
        </footer>

    </div>

</body>
</html>