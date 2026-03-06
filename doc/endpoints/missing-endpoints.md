# Missing Endpoints (Ranked)

Ranking is an informed estimate for your use case (course development + automated homework checking), ordered highest utility first.
Coverage comparison was made against the current SDK endpoint folders and `Canvas` methods.

<table>
  <thead>
    <tr>
      <th>Rank</th>
      <th>Endpoint(s)</th>
      <th>Required access level / privileges</th>
      <th>Why useful for your workflow</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>1</td>
      <td><code>GET/POST/PUT/DELETE /api/v1/courses/:course_id/assignments/:assignment_id/overrides</code> and related assignment override endpoints (<a href="https://canvas.instructure.com/doc/api/assignments.html">Assignments API</a>)</td>
      <td>Teacher/Designer with assignment management privileges</td>
      <td>Differentiated due dates and availability windows per student/section/group.</td>
    </tr>
    <tr>
      <td>2</td>
      <td><code>PUT /api/v1/courses/:course_id/assignments/:assignment_id/submissions/:user_id</code> and related submission moderation/read endpoints (<a href="https://canvas.instructure.com/doc/api/submissions.html">Submissions API</a>)</td>
      <td>Teacher/TA with grade management permissions</td>
      <td>Core for automated checking pipelines that push scores, comments, and grading state.</td>
    </tr>
    <tr>
      <td>3</td>
      <td><code>POST /api/v1/courses/:course_id/assignments/:assignment_id/extensions</code> (<a href="https://canvas.instructure.com/doc/api/assignment_extensions.html">Assignment Extensions API</a>)</td>
      <td>Teacher with permission to extend assignments</td>
      <td>Supports slower/faster learner pacing with extra attempts.</td>
    </tr>
    <tr>
      <td>4</td>
      <td><code>GET/PUT /api/v1/courses/:course_id/modules/:context_module_id/assignment_overrides</code> (<a href="https://www.canvas.instructure.com/doc/api/modules.html">Modules API</a>)</td>
      <td>Teacher/Designer managing modules and differentiated release</td>
      <td>Module-level differentiation complements assignment-level overrides.</td>
    </tr>
    <tr>
      <td>5</td>
      <td><code>PUT|DELETE /api/v1/courses/:course_id/modules/:module_id/items/:id/done</code>, <code>POST .../mark_read</code>, <code>PUT /api/v1/courses/:course_id/modules/:id/relock</code> (<a href="https://www.canvas.instructure.com/doc/api/modules.html">Modules API</a>)</td>
      <td>Student context for done/read; Teacher/Admin for re-locking progressions</td>
      <td>Lets you manage module progression state and reset pacing logic safely.</td>
    </tr>
    <tr>
      <td>6</td>
      <td><code>GET/POST/PUT/DELETE /api/v1/courses/:course_id/course_pacing(:id)</code> (<a href="https://canvas.instructure.com/doc/api/course_pace.html">Course Pace API</a>)</td>
      <td>Teacher/Admin with Course Pacing feature enabled</td>
      <td>Native pacing controls for differentiated timelines at course/section/user scope.</td>
    </tr>
    <tr>
      <td>7</td>
      <td><code>/api/v1/courses/:course_id/rubrics</code>, <code>/rubric_associations</code>, <code>/rubric_assessments</code> (<a href="https://www.canvas.instructure.com/doc/api/rubrics.html">Rubrics API</a>)</td>
      <td>Teacher/Designer (rubric design) and Teacher/TA (assessment)</td>
      <td>Essential for criterion-based grading and richer automated feedback.</td>
    </tr>
    <tr>
      <td>8</td>
      <td><code>/api/v1/courses/:course_id/assignments/:assignment_id/peer_reviews</code> and related create/delete/allocate endpoints (<a href="https://developerdocs.instructure.com/services/canvas/resources/peer_reviews">Peer Reviews API</a>)</td>
      <td>Teacher for assigning/removing; students for own allocations</td>
      <td>Supports collaborative assessment workflows in project-based courses.</td>
    </tr>
    <tr>
      <td>9</td>
      <td><code>/api/v1/courses/:course_id/quizzes/:quiz_id/submissions</code> and grade update endpoints (<a href="https://canvas.instructure.com/doc/api/quiz_submissions.html">Quiz Submissions API</a>)</td>
      <td>Teacher/TA for multi-user grading views and score adjustments</td>
      <td>Improves quiz analytics and automated or semi-automated grading loops.</td>
    </tr>
    <tr>
      <td>10</td>
      <td><code>/api/v1/courses/:course_id/sections</code> and section detail endpoints (<a href="https://www.canvas.instructure.com/doc/api/sections.html">Sections API</a>)</td>
      <td>Teacher/Admin with section visibility or management rights</td>
      <td>Required for section-scoped differentiation and targeted course operations.</td>
    </tr>
    <tr>
      <td>11</td>
      <td><code>/api/v1/courses/:course_id/enrollments</code> and related contexts (<a href="https://canvas.instructure.com/doc/api/enrollments.html">Enrollments API</a>)</td>
      <td>Teacher for own course visibility; root admin for broader enrollment access</td>
      <td>Important for participant syncing and role-aware automation.</td>
    </tr>
    <tr>
      <td>12</td>
      <td><code>/api/v1/courses/:course_id/outcome_results</code>, <code>/outcome_groups</code>, <code>/outcome_group_links</code> (<a href="https://developerdocs.instructure.com/services/canvas/resources/outcome_results">Outcome Results API</a>, <a href="https://canvas.instructure.com/doc/api/outcome_groups.html">Outcome Groups API</a>)</td>
      <td>Teacher/Admin with outcomes visibility and management permissions</td>
      <td>Competency tracking beyond raw assignment points.</td>
    </tr>
    <tr>
      <td>13</td>
      <td><code>POST /api/v1/courses/:course_id/content_migrations</code> and status/list endpoints (<a href="https://www.canvas.instructure.com/doc/api/content_migrations.html">Content Migrations API</a>)</td>
      <td>Teacher/Designer/Admin with import/copy permissions</td>
      <td>Automates cloning and templating course structures/content.</td>
    </tr>
    <tr>
      <td>14</td>
      <td><code>GET /api/v1/announcements</code> (<a href="https://developerdocs.instructure.com/services/canvas/file.all_resources/announcements">Announcements API</a>)</td>
      <td>View Announcements permission in target course contexts</td>
      <td>Useful for communication automation and monitoring important course updates.</td>
    </tr>
    <tr>
      <td>15</td>
      <td><code>/api/v1/courses/:course_id/discussion_topics</code> and thread endpoints (<a href="https://www.canvas.instructure.com/doc/api/discussion_topics.html">Discussion Topics API</a>)</td>
      <td>Teacher/TA/student depending operation and topic settings</td>
      <td>Enables automation around forum prompts and participation workflows.</td>
    </tr>
    <tr>
      <td>16</td>
      <td><code>/api/v1/courses/:course_id/gradebook_history/*</code> (<a href="https://canvas.instructure.com/doc/api/gradebook_history.html">Gradebook History API</a>)</td>
      <td>Teacher/Admin with grade visibility rights</td>
      <td>Auditability for grading changes and debugging grade sync issues.</td>
    </tr>
    <tr>
      <td>17</td>
      <td><code>/api/v1/courses/:course_id/blueprint_templates/*</code> (<a href="https://canvas.instructure.com/doc/api/blueprint_courses.html">Blueprint Courses API</a>)</td>
      <td>Account-level/blueprint management permissions</td>
      <td>Centralized multi-course rollout and synchronization.</td>
    </tr>
    <tr>
      <td>18</td>
      <td><code>/api/v1/courses/:course_id/external_tools</code> and launch/sessionless endpoints (<a href="https://www.canvas.instructure.com/doc/api/external_tools.html">External Tools API</a>)</td>
      <td>Course or account admins/designers with LTI tool management rights</td>
      <td>Needed when automating LTI-based homework tools and integrations.</td>
    </tr>
  </tbody>
</table>
