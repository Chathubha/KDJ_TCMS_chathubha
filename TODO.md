# Class Management System — Full Todo List

## Tech Stack
- **Backend:** Laravel 11 (PHP)
- **Database:** MySQL
- **Frontend:** Blade Templates + Tailwind CSS
- **Auth:** Laravel Breeze

---

## Phase 1: Foundation
- [ ] Install Laravel 11 with Breeze (Blade + Tailwind)
- [ ] Configure MySQL connection in `.env`
- [ ] Set up folder structure: `Modules/`, `Services/`, `Policies/`, `Events/`
- [ ] Create master Blade layout (sidebar, navbar, footer)
- [ ] Set up route groups per module in `routes/web.php`
- [ ] Configure Vite for Tailwind compilation
- [ ] Run default Breeze migrations, verify login/register works

---

## Phase 2: Auth & Roles
- [ ] Add `role` column to `users` table (admin, teacher, student)
- [ ] Create role middleware (`AdminOnly`, `TeacherOnly`, `StudentOnly`)
- [ ] Seed default admin user
- [ ] Build role-based dashboard redirect after login
  - Admin → admin dashboard
  - Teacher → teacher dashboard
  - Student → student dashboard
- [ ] Create user profile page (edit name, email, password)

---

## Phase 3: Students Module
- [ ] Migration: `students` table (name, email, dob, gender, phone, address, photo, user_id)
- [ ] Migration: `student_class` pivot (student_id, classroom_id, academic_year)
- [ ] Student model + relationships (`belongsTo User`, `belongsToMany Classroom`)
- [ ] `StudentService`: CRUD, search, filter by class
- [ ] `StudentController`: index, create, store, show, edit, update, destroy
- [ ] `StudentPolicy`: admin full access, teacher view assigned, student view own
- [ ] Blade views: student list (table), create/edit form, profile page
- [ ] Seed 20-30 sample students

---

## Phase 4: Teachers Module
- [ ] Migration: `teachers` table (name, email, phone, qualification, specialization, user_id)
- [ ] Migration: `teacher_subject` pivot (teacher_id, subject_id)
- [ ] Teacher model + relationships
- [ ] `TeacherService`: CRUD, assign/unassign subjects
- [ ] `TeacherController`: full CRUD
- [ ] `TeacherPolicy`
- [ ] Blade views: teacher list, create/edit form, profile
- [ ] Seed 10 sample teachers

---

## Phase 5: Classes Module
- [ ] Migration: `classrooms` table (name, section, capacity, academic_year, teacher_id)
- [ ] Classroom model + relationships (`hasMany Student` via pivot, `belongsTo Teacher` as class teacher)
- [ ] `ClassroomService`: CRUD, capacity check, student count
- [ ] `ClassroomController`
- [ ] `ClassroomPolicy`
- [ ] Blade views: class list with student count, create/edit form, class detail (enrolled students)
- [ ] Seed 8-10 classes (10-A, 10-B, 9-A, etc.)

---

## Phase 6: Subjects Module
- [ ] Migration: `subjects` table (name, code, description, classroom_id)
- [ ] Subject model + relationships (`belongsTo Classroom`, `belongsToMany Teacher`)
- [ ] `SubjectService`: CRUD, assign teachers
- [ ] `SubjectController`
- [ ] `SubjectPolicy`
- [ ] Blade views: subject list, create/edit form
- [ ] Seed 15-20 subjects (Math, Science, English, etc.)

---

## Phase 7: Attendance Module
- [ ] Migration: `attendances` table (student_id, classroom_id, subject_id, date, status, marked_by)
- [ ] Status enum: present, absent, late, excused
- [ ] `AttendanceService`: mark bulk, get by date/class, summary stats
- [ ] `AttendanceController`: mark page, store, history, report
- [ ] `AttendancePolicy`
- [ ] Blade views:
  - Mark attendance page (grid: students × mark buttons)
  - Attendance history (filter by class, date range)
  - Attendance report (percentage per student)
- [ ] Event: `StudentEnrolled` → auto-init attendance records

---

## Phase 8: Grades Module
- [ ] Migration: `exams` table (name, subject_id, classroom_id, date, max_marks, weight)
- [ ] Migration: `grades` table (student_id, exam_id, marks_obtained, remarks)
- [ ] Grade model + relationships
- [ ] `GradeService`: enter marks, calculate totals, generate report card
- [ ] `GradeController`: enter marks (bulk form), view grades, report card
- [ ] `GradePolicy`
- [ ] Blade views:
  - Exam list per class/subject
  - Bulk marks entry form (table: student × input field)
  - Individual student report card (printable)
  - Class performance summary
- [ ] Seed sample exams and grades

---

## Phase 9: Schedule Module
- [ ] Migration: `periods` table (name, start_time, end_time, order)
- [ ] Migration: `schedules` table (classroom_id, subject_id, teacher_id, period_id, day)
- [ ] Schedule model + relationships
- [ ] `ScheduleService`: CRUD, conflict detection (teacher double-booked), generate view
- [ ] `ScheduleController`
- [ ] `SchedulePolicy`
- [ ] Blade views:
  - Timetable grid (rows: periods, columns: days)
  - Create/edit schedule form
  - Teacher's weekly schedule
  - Class weekly schedule

---

## Phase 10: Dashboard & Reports
- [ ] Admin dashboard: total students, teachers, classes, attendance %, recent activity
- [ ] Teacher dashboard: assigned classes, today's attendance, upcoming exams
- [ ] Student dashboard: my attendance %, my grades, my schedule
- [ ] Attendance report: export to CSV/PDF per class or student
- [ ] Grade report: class average, top performers, subject-wise breakdown
- [ ] Search: global search across students, teachers

---

## Phase 11: Polish & Deployment
- [ ] Form validation on all create/edit forms
- [ ] Flash messages (success/error) on all actions
- [ ] Pagination on all list views
- [ ] Confirm dialogs on delete actions
- [ ] Responsive design (mobile-friendly sidebar + tables)
- [ ] Error pages (404, 403, 500)
- [ ] Database seeders for full demo data
- [ ] `.env.example` updated with all config
- [ ] README: setup instructions, seed command, default credentials
- [ ] Final review: security (CSRF, XSS, SQL injection handled by Laravel)

---

## Execution Order

| Phase | Depends On    | Estimated Effort |
|-------|---------------|------------------|
| 1. Foundation    | —              | Small  |
| 2. Auth & Roles  | Phase 1        | Small  |
| 3. Students      | Phase 2        | Medium |
| 4. Teachers      | Phase 2        | Medium |
| 5. Classes       | Phase 3, 4     | Medium |
| 6. Subjects      | Phase 4, 5     | Medium |
| 7. Attendance    | Phase 3, 5, 6  | Large  |
| 8. Grades        | Phase 3, 5, 6  | Large  |
| 9. Schedule      | Phase 4, 5, 6  | Medium |
| 10. Dashboard    | All above      | Medium |
| 11. Polish       | All above      | Medium |

**Parallel opportunities:** Phases 3 & 4 | Phases 7, 8 & 9
