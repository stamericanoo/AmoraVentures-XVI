<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amora Ventures | Radiant Engineering Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&family=Inter:wght@300;400;600;800&family=JetBrains+Mono&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            /* RADIANT COLOR PALETTE */
            --bg-main: #f1f5f9; /* Light Slate Gray */
            --panel-bg: #ffffff; /* Pure White Panels */
            --text-main: #0f172a; /* Dark Navy Text */
            --text-dim: #64748b; /* Dimmed Gray Text */
            --maroon: #991b1b; /* Rich Maroon for Accents */
            --maroon-bright: #ef4444; /* Bright Red for Highlighting */
            --gold: #d97706; /* Darker Gold for visibility on light bg */
        }

        * { scroll-behavior: smooth; box-sizing: border-box; }
        body { margin: 0; font-family: 'Inter', sans-serif; background: var(--bg-main); color: var(--text-main); overflow-x: hidden; }

        /* HERO SECTION */
        .hero {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: linear-gradient(rgba(241, 245, 249, 0.95), rgba(153, 27, 27, 0.1)), url('https://images.unsplash.com/photo-1541976590-713941681591?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-attachment: fixed;
            text-align: center;
        }
        .hero h1 { font-family: 'Montserrat'; font-size: 6rem; font-weight: 900; margin: 0; line-height: 0.8; letter-spacing: -3px; }
        .hero h1 span { color: var(--maroon); text-shadow: 0 0 20px rgba(153, 27, 27, 0.1); }
        .hero p { font-size: 1.2rem; letter-spacing: 10px; text-transform: uppercase; margin-top: 30px; color: var(--gold); }

        /* FLOATING SIDE NAV */
        .side-nav { position: fixed; right: 20px; top: 50%; transform: translateY(-50%); z-index: 1000; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(5px); padding: 20px 10px; border-radius: 40px; border: 1px solid #e2e8f0; }
        .dot { width: 12px; height: 12px; background: var(--text-dim); border-radius: 50%; margin: 15px 0; display: block; transition: 0.3s; position: relative; cursor: pointer; border: 1px solid transparent; }
        .dot.active { background: var(--maroon); transform: scale(1.6); box-shadow: 0 0 10px rgba(153, 27, 27, 0.3); border-color: white; }

        /* LAYOUT SYSTEM */
        section { padding: 150px 10%; border-bottom: 1px solid #e2e8f0; }
        .section-header { margin-bottom: 60px; }
        .section-header h2 { font-family: 'Montserrat'; font-size: 3.5rem; font-weight: 900; text-transform: uppercase; color: var(--text-main); }
        .section-header div { width: 120px; height: 8px; background: var(--maroon); margin-top: 15px; }

        /* CONTENT CARDS - LIGHT THEME */
        .content-card { background: var(--panel-bg); padding: 50px; border-radius: 12px; border-top: 10px solid var(--maroon); margin-bottom: 60px; transition: 0.3s; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
        .content-card:hover { transform: translateY(-10px); }

        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; }
        
        /* DATA TABLES */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff; }
        th { text-align: left; padding: 20px; color: var(--gold); border-bottom: 2px solid var(--maroon); font-size: 0.8rem; text-transform: uppercase; }
        td { padding: 18px; border-bottom: 1px solid #e2e8f0; color: var(--text-main); font-size: 0.95rem; }
        tr:hover td { background: #f8fafc; }

        /* FORMULAS */
        .formula { font-family: 'JetBrains Mono'; background: #f8fafc; padding: 25px; border-radius: 8px; color: #166534; margin: 20px 0; border-left: 5px solid var(--maroon); border-right: none; }

        /* TIER SELECTOR ALIGNED TO TOP NAV STYLE */
        .top-nav { display: flex; justify-content: space-around; background: var(--panel-bg); padding: 10px 10%; border-bottom: 4px solid var(--maroon); position: sticky; top: 0; z-index: 100; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .stat-btn { background: transparent; border: none; padding: 15px 25px; cursor: pointer; color: var(--text-main); font-weight: bold; transition: 0.3s; }
        .stat-btn:hover, .stat-btn.active { color: var(--maroon); }
        
        .tier-control { text-align: center; margin: 50px 0; }
        .tier-btn { padding: 15px 35px; border-radius: 50px; border: none; cursor: pointer; margin: 10px; font-weight: 800; text-transform: uppercase; transition: 0.3s; }
        .btn-basic { background: #64748b; color: white; }
        .btn-std { background: #166534; color: white; }
        .btn-premium { background: #6d28d9; color: white; }
        .tier-btn:hover { transform: scale(1.1); filter: brightness(1.2); }

        /* CHARTS */
        .chart-container { background: white; padding: 30px; border-radius: 12px; margin-top: 30px; height: 400px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }

        /* FOOTER ALA AZZAM */
        .academic-info { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; color: var(--text-dim); font-size: 0.9rem; margin-top: 50px; border-top: 1px solid #e2e8f0; padding-top: 30px; }
        footer { padding: 80px 10%; background: #fff; text-align: center; border-top: 5px solid var(--maroon); }

        /* ANIMATIONS */
        .reveal { opacity: 0; transform: translateY(50px); transition: 0.8s ease-out; }
        .reveal.active { opacity: 1; transform: translateY(0); }
    </style>
</head>
<body>

    <nav class="side-nav">
        <a href="#hero" class="dot active"></a>
        <a href="#summary" class="dot"></a>
        <a href="#selector" class="dot"></a>
        <a href="#process" class="dot"></a>
        <a href="#economics" class="dot"></a>
        <a href="#safety" class="dot"></a>
    </nav>

    <section class="hero" id="hero">
        <h1>AMORA<br><span>VENTURES</span></h1>
        <p>1,000 MTPD SULFURIC ACID PROJECT</p>
        <div style="margin-top: 50px; font-weight: 800; font-size: 1.5rem; color: var(--maroon);">ADVANCED INDUSTRIAL SIMULATION</div>
    </section>

    <div class="top-nav">
        <button class="stat-btn active">Process</button>
        <button class="stat-btn">Mass Balance</button>
        <button class="stat-btn">Financials</button>
        <div style="padding: 15px 0;">Average Efficiency: <b id="avg-eff" style="color: var(--maroon);">95.0%</b></div>
    </div>

    <section id="selector">
        <div class="section-header">
            <h2>01. Dynamic <span>Equipment Selector</span></h2>
            <div></div>
        </div>
        <p style="text-align: center; color: var(--text-dim);">Adjust equipment tier to see real-time impact on efficiency and cost:</p>
        
        <div class="tier-control">
            <button class="tier-btn btn-basic" onclick="setTier('basic')">$ Basic Tier (Cost-Effective)</button>
            <button class="tier-btn btn-std" onclick="setTier('standard')">⭐ Standard Tier (Recommended)</button>
            <button class="tier-btn btn-premium" onclick="setTier('premium')">👑 Premium Tier (Optimal Performance)</button>
        </div>

        <div class="grid-2">
            <div class="content-card">
                <h3>Sulfur Furnace (F-101)</h3>
                <p>Tiers affect combustion efficiency and fuel consumption.</p>
                <table>
                    <tr><td>Current Tier:</td><td id="f-tier">Standard</td></tr>
                    <tr><td>Estimated Cost:</td><td id="f-price">Rp 26.00 M</td></tr>
                    <tr><td>Efficiency:</td><td id="f-eff">95%</td></tr>
                </table>
            </div>
            <div class="content-card">
                <h3>DCDA Converter (R-201)</h3>
                <p>Advanced tiers use premium catalysts for near-perfect conversion.</p>
                <table>
                    <tr><td>Current Tier:</td><td id="r-tier">Standard</td></tr>
                    <tr><td>Estimated Cost:</td><td id="r-price">Rp 48.00 M</td></tr>
                    <tr><td>Efficiency:</td><td id="r-eff">98%</td></tr>
                </table>
            </div>
        </div>
    </section>

    <section id="process" class="reveal">
        <div class="section-header">
            <h2>02. Mass <span>Balance</span></h2>
            <div></div>
        </div>
        <div class="content-card">
            <h3>Hourly Stream Composition</h3>
            <table>
                <thead>
                    <tr><th>Stream</th><th>Flow (kg/h)</th><th>Primary Components</th></tr>
                </thead>
                <tbody>
                    <tr><td>Sulfur Feed</td><td>7,541.67</td><td>Liquid Sulfur (100%)</td></tr>
                    <tr><td>Process Air</td><td>62,450.00</td><td>Dry $O_2$, $N_2$</td></tr>
                    <tr><td>Burner Exit</td><td>69,991.67</td><td>10.5% $SO_2$ gas</td></tr>
                    <tr><td>Converter Exit</td><td>69,991.67</td><td>$SO_3$ gas (DCDA conversion)</td></tr>
                    <tr style="font-weight: 800; color: var(--maroon);"><td>Product</td><td>41,666.67</td><td>98.0% Asam Sulfat</td></tr>
                </tbody>
            </table>
        </div>
        
    </section>

    <section id="economics" class="reveal">
        <div class="section-header">
            <h2>03. Financial <span>Feasibility</span></h2>
            <div></div>
        </div>
        <div class="chart-container">
            <canvas id="profitChart"></canvas>
        </div>
        <div class="grid-2" style="margin-top: 30px;">
            <div style="text-align: center; padding: 20px; background: white; border-radius: 8px;">
                <h1 style="color: var(--gold); margin: 0;">10.3 Yrs</h1>
                <p>Payback Period</p>
            </div>
            <div style="text-align: center; padding: 20px; background: white; border-radius: 8px;">
                <h1 style="color: var(--gold); margin: 0;">56.1%</h1>
                <p>Break Even Point</p>
            </div>
        </div>
    </section>

    <section id="safety" class="reveal">
        <div class="section-header">
            <h2>04. <span>SHE</span> & Safety</h2>
            <div></div>
        </div>
        <div class="content-card" style="background: #fef2f2; border: 2px solid var(--maroon-bright);">
            <h3 style="color: var(--maroon-bright);">Hazard Management</h3>
            <p>Sulfuric acid handling poses extreme risks. Our SHE protocols focus on prevention and containment.</p>
            <div class="formula" style="border-left-color: var(--maroon-bright); color: #991b1b;">
                Danger: Exothermic Hydration<br>
                $H_2SO_4$ reacts violently with water.
            </div>
        </div>
    </section>

    <footer>
        <h2 style="font-family: 'Montserrat'; font-size: 2rem;">AMORA VENTURES</h2>
        <p>Advanced Industrial Solutions | ChemEng Dept 2026</p>
        
        <div style="border: 1px solid var(--gold); padding: 20px; border-radius: 8px; margin-top: 30px; color: var(--gold); text-align: left;">
            <b style="color: var(--maroon);">⚠️ DISCLAIMER:</b> This website is an <b>academic simulation</b> for the class of 2026. All figures are estimates based on realistic industry data and public models. Last Updated: 28 February 2026.
        </div>

        <div class="academic-info">
            <div style="text-align: left;">
                <p>Mata Pelajaran: Kimia Industri - Plant Design</p>
                <p>Anggota Tim: Aisha, Keysha, Jovita</p>
            </div>
            <div style="text-align: right;">
                <p>Versi: 4.1 "Radiant Final"</p>
                <p>Tahun Ajaran: 2025/2026</p>
            </div>
        </div>
        <a href="#top" style="color: var(--maroon); text-decoration: none; font-weight: bold; display: block; margin-top: 30px;">KEMBALI KE ATAS ↑</a>
    </footer>

    <script>
        // AOS Implementation
        window.addEventListener('scroll', () => {
            const reveals = document.querySelectorAll('.reveal');
            reveals.forEach(r => {
                const wh = window.innerHeight;
                const rtop = r.getBoundingClientRect().top;
                if (rtop < wh - 150) r.classList.add('active');
            });

            // SIDE NAV TRACKER
            const sections = document.querySelectorAll('section');
            const dots = document.querySelectorAll('.dot');
            let current = "";
            sections.forEach(s => { if (pageYOffset >= s.offsetTop - 300) current = s.getAttribute('id'); });
            dots.forEach(d => { d.classList.remove('active'); if (d.getAttribute('href').includes(current)) d.classList.add('active'); });
        });

        // TIER DATA
        const tiers = {
            basic: { f:18, r:32, effs:[88, 90] },
            standard: { f:26, r:48, effs:[95, 98] },
            premium: { f:35, r:65, effs:[99, 99.7] }
        };

        function setTier(tName) {
            const d = tiers[tName];
            const label = tName.charAt(0).toUpperCase() + tName.slice(1);
            
            // F-101
            document.getElementById('f-tier').innerText = label;
            document.getElementById('f-price').innerText = `Rp ${d.f}.00 M`;
            document.getElementById('f-eff').innerText = `${d.effs[0]}%`;

            // R-201
            document.getElementById('r-tier').innerText = label;
            document.getElementById('r-price').innerText = `Rp ${d.r}.00 M`;
            document.getElementById('r-eff').innerText = `${d.effs[1]}%`;

            // AVG
            const avg = (d.effs.reduce((a,b) => a+b)/2).toFixed(1);
            document.getElementById('avg-eff').innerText = `${avg}%`;
        }

        // CHART
        new Chart(document.getElementById('profitChart'), {
            type: 'line',
            data: {
                labels: ['Y1', 'Y2', 'Y3', 'Y4', 'Y5', 'Y6'],
                datasets: [{ label: 'Cumulative Profit (Billion IDR)', data: [10, 50, 94.5, 140, 200, 270], borderColor: '#ef4444', backgroundColor: 'rgba(239, 68, 68, 0.05)', fill: true, tension: 0.3 }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        setTier('standard');
    </script>
</body>
</html>
