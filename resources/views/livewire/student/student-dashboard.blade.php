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
                <span class="info-value" style="font-weight: 600; font-size: 0.9rem; color: #10b981;">SWD 317</span>
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
                        <td data-label="Course"><strong>CSC 301</strong><br><small style="color:var(--text-muted)">Data
                                Structures</small></td>
                        <td data-label="Attendance">
                            <div class="progress-container">
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 85%"></div>
                                </div>
                                <span>85%</span>
                            </div>
                        </td>
                        <td data-label="Status" class="hide-mobile"><span class="badge badge-success">Excellent</span>
                        </td>
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
                        <td data-label="Status" class="hide-mobile"><span class="badge badge-success">Excellent</span>
                        </td>
                        <td><a href="{{ route('student-logs', ['course_id' => '1']) }}" class="btn-primary"
                                style="padding: 8px 12px; font-size: 0.8rem; background: #f1f5f9; color: var(--text-main);">View
                                Logs</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
