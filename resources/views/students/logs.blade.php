<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Logs | CSC 301</title>
    <link rel="icon" href="{{ asset('assets/images/logo/logo.png') }}" sizes="any">
    <link rel="icon" href="{{ asset('assets/images/logo/logo.png') }}" type="image/svg+xml">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/logo/logo.png') }}">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --bg-main: #f8fafc;
            --card-bg: #ffffff;
            --primary: #10b981;
            /* Green */
            --danger: #ef4444;
            /* Red */
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --radius: 16px;
        }

        body {
            margin: 0;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: var(--bg-main);
            color: var(--text-main);
            padding: 20px;
            line-height: 1.6;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        /* NAVIGATION HEADER */
        .back-nav {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 500;
            font-size: 14px;
            transition: color 0.2s;
        }

        .back-nav:hover {
            color: var(--primary);
        }

        /* COURSE HEADER CARD */
        .header-card {
            background: linear-gradient(135deg, #064e3b 0%, #022c22 100%);
            color: white;
            padding: 32px;
            border-radius: var(--radius);
            margin-bottom: 24px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .course-info h1 {
            margin: 0;
            font-size: 24px;
            letter-spacing: -0.5px;
        }

        .course-info p {
            margin: 4px 0 0;
            opacity: 0.8;
            font-size: 14px;
        }

        .stats-grid {
            display: flex;
            gap: 24px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            display: block;
            font-size: 20px;
            font-weight: 700;
            color: #6ee7b7;
        }

        .stat-label {
            font-size: 11px;
            text-transform: uppercase;
            opacity: 0.7;
            letter-spacing: 1px;
        }

        /* LOGS SECTION */
        .logs-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .logs-title {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .log-row {
            display: grid;
            grid-template-columns: 80px 1fr 120px 100px;
            align-items: center;
            padding: 16px 24px;
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.2s;
        }

        .log-row:hover {
            background: #fbfcfe;
        }

        .log-row:last-child {
            border-bottom: none;
        }

        /* DATE STYLE */
        .date-box {
            text-align: center;
            background: #f1f5f9;
            padding: 6px;
            border-radius: 8px;
            font-weight: 700;
            line-height: 1.2;
            width: 50px;
        }

        .date-box small {
            display: block;
            font-size: 10px;
            color: var(--text-muted);
            text-transform: uppercase;
        }

        .session-type {
            font-size: 13px;
            color: var(--text-muted);
        }

        /* STATUS BADGES */
        .status {
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .present {
            color: var(--primary);
        }

        .absent {
            color: var(--danger);
        }

        .time {
            font-size: 13px;
            color: var(--text-muted);
            font-family: monospace;
        }

        /* RESPONSIVE STACKING */
        @media (max-width: 600px) {
            .log-row {
                grid-template-columns: 60px 1fr 1fr;
                gap: 10px;
            }

            .time {
                grid-column: 2;
                font-size: 11px;
            }

            .status {
                justify-self: end;
            }

            .header-card {
                padding: 20px;
                text-align: center;
                justify-content: center;
            }

            .stats-grid {
                width: 100%;
                justify-content: space-around;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- Back to Dashboard -->
        <a href="{{ route('student.dashboard') }}" class="back-nav">
            <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
        </a>

        <!-- Top Summary Card -->
        <div class="header-card">
            <div class="course-info">
                <h1>CSC 301 Logs</h1>
                <p>Data Structures & Algorithms • HND 1</p>
            </div>
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-value">12</span>
                    <span class="stat-label">Total Sessions</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">10</span>
                    <span class="stat-label">Attended</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">83%</span>
                    <span class="stat-label">Score</span>
                </div>
            </div>
        </div>

        <!-- Attendance Log List -->
        <div class="logs-card">
            <div class="logs-title">
                <span>Detailed History</span>
                <span style="font-size: 12px; color: var(--text-muted); font-weight: normal;">Semester 1</span>
            </div>

            <!-- Log Item 1 -->
            <div class="log-row">
                <div class="date-box">
                    24<br><small>May</small>
                </div>
                <div>
                    <div style="font-weight: 600;">Standard Lecture</div>
                    <div class="session-type">Theory • Binary Trees</div>
                </div>
                <div class="time">09:00 AM</div>
                <div class="status present">
                    <i class="fa-solid fa-circle-check"></i> Present
                </div>
            </div>

            <!-- Log Item 2 -->
            <div class="log-row">
                <div class="date-box">
                    21<br><small>May</small>
                </div>
                <div>
                    <div style="font-weight: 600;">Lab Session</div>
                    <div class="session-type">Practical • Linked Lists</div>
                </div>
                <div class="time">02:30 PM</div>
                <div class="status absent">
                    <i class="fa-solid fa-circle-xmark"></i> Absent
                </div>
            </div>

            <!-- Log Item 3 -->
            <div class="log-row">
                <div class="date-box">
                    17<br><small>May</small>
                </div>
                <div>
                    <div style="font-weight: 600;">Standard Lecture</div>
                    <div class="session-type">Theory • Sorting Algos</div>
                </div>
                <div class="time">09:15 AM</div>
                <div class="status present">
                    <i class="fa-solid fa-circle-check"></i> Present
                </div>
            </div>

            <!-- Log Item 4 -->
            <div class="log-row">
                <div class="date-box">
                    14<br><small>May</small>
                </div>
                <div>
                    <div style="font-weight: 600;">Standard Lecture</div>
                    <div class="session-type">Theory • Big O Notation</div>
                </div>
                <div class="time">10:00 AM</div>
                <div class="status present">
                    <i class="fa-solid fa-circle-check"></i> Present
                </div>
            </div>

            <!-- Log Item 5 -->
            <div class="log-row" style="opacity: 0.6; background: #fcfcfc;">
                <div class="date-box">
                    10<br><small>May</small>
                </div>
                <div>
                    <div style="font-weight: 600;">Revision Class</div>
                    <div class="session-type">Theory • General Intro</div>
                </div>
                <div class="time">08:00 AM</div>
                <div class="status absent">
                    <i class="fa-solid fa-circle-xmark"></i> Absent
                </div>
            </div>

        </div>

        <!-- Footer Meta -->
        <div style="text-align: center; margin-top: 30px; color: var(--text-muted); font-size: 12px;">
            <p>Attendance data is updated in real-time by the course coordinator.</p>
        </div>
    </div>

</body>

</html>
