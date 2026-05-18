<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Student Portal</title>
    <link rel="icon" href="{{ asset('assets/images/logo/logo.png') }}" sizes="any">
    <link rel="icon" href="{{ asset('assets/images/logo/logo.png') }}" type="image/svg+xml">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/logo/logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --bg-main: #f8fafc;
            --card-bg: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --success: #22c55e;
            --danger: #ef4444;
            --radius: 16px;
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }

        body {
            margin: 0;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: var(--bg-main);
            color: var(--text-main);
            line-height: 1.5;
        }

        .dashboard {
            display: grid;
            grid-template-columns: 1fr;
            max-width: 1200px;
            margin: 0 auto;
            padding: 24px;
            gap: 24px;
        }

        @media (min-width: 1024px) {
            .dashboard {
                grid-template-columns: 350px 1fr;
                padding: 40px;
            }
        }

        /* TYPOGRAPHY */
        h1 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 2rem;
            grid-column: 1 / -1;
        }

        .section-title {
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* CARD STYLE */
        .card {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 24px;
            box-shadow: var(--shadow);
            border: 1px solid #e2e8f0;
            transition: transform 0.2s;
        }

        /* STUDENT PROFILE CARD */
        .profile-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        .avatar {
            width: 56px;
            height: 56px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .info-row:last-child {
            border: none;
        }

        .info-label {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .info-value {
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* ATTENDANCE ACTION CARD */
        .attendance-card {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: white;
        }

        .attendance-card .section-title {
            color: #94a3b8;
        }

        .input-group {
            position: relative;
            margin: 20px 0 10px;
        }

        .input-modern {
            width: 100%;
            padding: 14px;
            box-sizing: border-box;
            border-radius: 12px;
            border: 1px solid #334155;
            background: #334155;
            color: white;
            font-size: 1rem;
            text-align: center;
            letter-spacing: 4px;
        }

        .input-modern:focus {
            outline: 2px solid var(--primary);
            border-color: transparent;
        }

        .btn-primary {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            border: none;
            background: var(--primary);
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        /* DATA TABLE */
        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        th {
            text-align: left;
            padding: 12px 16px;
            font-size: 0.75rem;
            color: var(--text-muted);
            border-bottom: 1px solid #f1f5f9;
        }

        td {
            padding: 16px;
            font-size: 0.9rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .badge {
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-warning {
            background: #fef9c3;
            color: #a16207;
        }

        /* PROGRESS BAR */
        .progress-container {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 120px;
        }

        .progress-bar {
            height: 8px;
            background: #e2e8f0;
            border-radius: 4px;
            flex-grow: 1;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: var(--primary);
            border-radius: 4px;
        }

        /* MOBILE STACKING */
        @media (max-width: 640px) {
            .dashboard {
                padding: 16px;
            }

            .hide-mobile {
                display: none;
            }

            td {
                display: block;
                padding: 8px 16px;
                border: none;
            }

            tr {
                display: block;
                padding: 12px 0;
                border-bottom: 1px solid #f1f5f9;
            }

            td::before {
                content: attr(data-label);
                display: block;
                font-size: 0.7rem;
                color: var(--text-muted);
                font-weight: 600;
            }
        }
    </style>
</head>

<body>

    <div class="dashboard">
        <h1>Welcome back, Stephen 👋</h1>

        <!-- LEFT COLUMN -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <!-- PROFILE -->
            <div class="card"
                style="background: #ffffff; border-radius: 16px; padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                <div class="profile-header" style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px;">
                    <div class="avatar"
                        style="width: 56px; height: 56px; background: #10b981; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold;">
                        SW</div>
                    <div>
                        <div style="font-weight: 700; font-size: 1.1rem; color: #1e293b;">Stephen Williams</div>
                        <div style="font-size: 0.85rem; color: #64748b;">Computer Science Student</div>
                    </div>
                </div>

                <div class="info-row"
                    style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f1f5f9;">
                    <span class="info-label" style="color: #64748b; font-size: 0.9rem;">Registration No.</span>
                    <span class="info-value"
                        style="font-weight: 600; font-size: 0.9rem; color: #1e293b;">FPN/HNDM/2024/001</span>
                </div>
                <div class="info-row"
                    style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f1f5f9;">
                    <span class="info-label" style="color: #64748b; font-size: 0.9rem;">Level</span>
                    <span class="info-value" style="font-weight: 600; font-size: 0.9rem; color: #1e293b;">HND 1</span>
                </div>
                <div class="info-row"
                    style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f1f5f9;">
                    <span class="info-label" style="color: #64748b; font-size: 0.9rem;">Active Courses</span>
                    <span class="info-value" style="font-weight: 600; font-size: 0.9rem; color: #10b981;">5 Units</span>
                </div>


                <!-- LOGOUT SECTION -->
                <form id="logout-form" action="{{ route('student.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    style="text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 20px; padding: 12px; border-radius: 12px; background: #fff1f2; color: #e11d48; font-size: 0.9rem; font-weight: 600; transition: all 0.2s; border: 1px solid #ffe4e6;"
                    onmouseover="this.style.background='#ffe4e6'" onmouseout="this.style.background='#fff1f2'">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout Account
                </a>
            </div>

            <!-- QUICK ATTENDANCE -->
            <div class="card attendance-card">
                <div class="section-title"><i class="fa-solid fa-satellite-dish"></i> Live Session</div>
                <div style="font-size: 1.1rem; font-weight: 600; margin-top: 8px;">CSC 301</div>
                <div style="font-size: 0.85rem; color: #94a3b8;">Data Structures & Algorithms</div>

                <div class="input-group">
                    <input type="text" class="input-modern" placeholder="••••">
                </div>
                <button class="btn-primary">
                    Mark Attendance
                </button>
                <p style="font-size: 0.75rem; color: #64748b; text-align: center; margin-top: 12px;">
                    Verification code expires in <span style="color: #cbd5e1; font-weight: 600;">08:42</span>
                </p>
            </div>
        </div>

        <!-- RIGHT COLUMN -->
        <div class="card">
            <div class="section-title"><i class="fa-solid fa-chart-line"></i> Attendance Analytics</div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>COURSE NAME</th>
                            <th>ATTENDANCE RATE</th>
                            <th class="hide-mobile">STATUS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td data-label="Course"><strong>CSC 301</strong><br><small
                                    style="color:var(--text-muted)">Data Structures</small></td>
                            <td data-label="Attendance">
                                <div class="progress-container">
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: 85%"></div>
                                    </div>
                                    <span>85%</span>
                                </div>
                            </td>
                            <td data-label="Status" class="hide-mobile"><span
                                    class="badge badge-success">Excellent</span></td>
                            <td><a href="{{ route('student-logs', ['course_id' => '6']) }}" class="btn-primary"
                                    style="padding: 8px 12px; font-size: 0.8rem; background: #f1f5f9; color: var(--text-main);">View
                                    Logs</a></td>
                        </tr>
                        <tr>
                            <td data-label="Course"><strong>CSC 305</strong><br><small
                                    style="color:var(--text-muted)">Operating Systems</small></td>
                            <td data-label="Attendance">
                                <div class="progress-container">
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: 62%; background: var(--danger);"></div>
                                    </div>
                                    <span>62%</span>
                                </div>
                            </td>
                            <td data-label="Status" class="hide-mobile"><span class="badge badge-warning">At Risk</span>
                            </td>
                            <td><a href="{{ route('student-logs', ['course_id' => '7']) }}" class="btn-primary"
                                    style="padding: 8px 12px; font-size: 0.8rem; background: #f1f5f9; color: var(--text-main);">View
                                    Logs</a></td>
                        </tr>
                        <tr>
                            <td data-label="Course"><strong>CSC 302</strong><br><small
                                    style="color:var(--text-muted)">Database Mgmt</small></td>
                            <td data-label="Attendance">
                                <div class="progress-container">
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: 92%"></div>
                                    </div>
                                    <span>92%</span>
                                </div>
                            </td>
                            <td data-label="Status" class="hide-mobile"><span
                                    class="badge badge-success">Excellent</span></td>
                            <td><a href="{{ route('student-logs', ['course_id' => '1']) }}" class="btn-primary"
                                    style="padding: 8px 12px; font-size: 0.8rem; background: #f1f5f9; color: var(--text-main);">View
                                    Logs</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>
