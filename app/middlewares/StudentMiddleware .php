<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentMiddleware
{
	public function handle(Closure $next)
	{
		if (session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}

		if (($_SESSION['student_access'] ?? false) !== true) {
			http_response_code(403);
			echo '<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NOVA-CRED // Access Denied</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
<style>
  :root{
    --void-950:#05010f;
    --pink-500:#ff2d9a;
    --pink-400:#ff6fc6;
    --pink-300:#ffa8dc;
    --violet-500:#a855f7;
    --text-hi:#fdf2fb;
    --text-mu:#c9b6d9;
  }
  *{box-sizing:border-box;}
  body{
    margin:0; min-height:100vh; display:flex; align-items:center; justify-content:center;
    background:
      radial-gradient(ellipse 90% 60% at 15% -10%, rgba(255,45,154,0.28), transparent 60%),
      radial-gradient(ellipse 80% 60% at 100% 0%, rgba(168,85,247,0.22), transparent 55%),
      var(--void-950);
    color:var(--text-hi);
    font-family:"JetBrains Mono", monospace;
    padding:24px;
  }
  .panel{
    max-width:420px; width:100%; text-align:center; position:relative;
    background:linear-gradient(160deg, rgba(255,255,255,0.07), rgba(255,255,255,0.02));
    border:1px solid rgba(255,111,198,0.3);
    border-radius:24px;
    backdrop-filter:blur(18px);
    box-shadow:0 8px 32px rgba(5,1,15,0.5), inset 0 1px 0 rgba(255,255,255,0.06);
    padding:40px 32px;
    animation:fadeUp .6s ease both;
  }
  @keyframes fadeUp{ from{opacity:0; transform:translateY(14px);} to{opacity:1; transform:translateY(0);} }
  .code{
    font-family:"Orbitron", sans-serif;
    font-weight:900;
    font-size:3.2rem;
    line-height:1;
    background:linear-gradient(90deg, var(--pink-400), var(--pink-300), var(--violet-500));
    -webkit-background-clip:text;
    background-clip:text;
    color:transparent;
    text-shadow:0 0 30px rgba(255,111,198,0.35);
    animation:pulseGlow 2.4s ease-in-out infinite;
  }
  @keyframes pulseGlow{ 0%,100%{filter:drop-shadow(0 0 6px rgba(255,45,154,0.35));} 50%{filter:drop-shadow(0 0 18px rgba(255,45,154,0.65));} }
  .tag{
    display:inline-flex; align-items:center; gap:6px;
    font-size:11px; letter-spacing:0.2em; color:var(--pink-300);
    margin-bottom:14px;
  }
  .dot{ width:6px; height:6px; border-radius:9999px; background:var(--pink-500); box-shadow:0 0 0 0 rgba(255,45,154,0.6); animation:pulseDot 2s ease-in-out infinite; }
  @keyframes pulseDot{ 0%,100%{box-shadow:0 0 0 0 rgba(255,45,154,0.55);} 50%{box-shadow:0 0 0 7px rgba(255,45,154,0);} }
  p.msg{ color:var(--text-mu); font-size:13px; line-height:1.6; margin:14px 0 24px; }
  a.back{
    display:inline-flex; align-items:center; gap:8px;
    font-size:12px; text-decoration:none; color:#fff;
    padding:10px 20px; border-radius:9999px;
    background:linear-gradient(90deg, var(--pink-500), var(--violet-500));
    box-shadow:0 8px 22px rgba(255,45,154,0.25);
    transition:transform .2s ease;
  }
  a.back:hover{ transform:translateY(-2px); }
</style>
</head>
<body>
  <div class="panel">
    <div class="tag"><span class="dot"></span>ACCESS CONTROL</div>
    <div class="code">403</div>
    <h1 style="font-family:\'Orbitron\',sans-serif; font-size:1.05rem; letter-spacing:0.05em; margin:14px 0 0;">Forbidden</h1>
    <p class="msg">You are not allowed to access the student profile.</p>
    <a class="back" href="' . site_url('student') . '">&#8592; Go back to Student Page</a>
  </div>
</body>
</html>';
			exit;
		}

		return $next();
	}
}