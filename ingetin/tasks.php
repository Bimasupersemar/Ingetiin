<?php
require_once 'includes/header.php';
require_once 'function/tasks.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$tasks = getAllTasksByUser($username);
?>

<?php if (isset($_SESSION['pesan'])): ?>
  <div class="alert alert-info"><?= $_SESSION['pesan'] ?></div>
  <?php unset($_SESSION['pesan']); ?>
<?php endif; ?>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $('.complete-task-btn').click(function(e){
        e.preventDefault();
        var taskId = $(this).data('id');
        var button = $(this);

        $.ajax({
            url: 'complete_task.php',
            type: 'POST',
            data: { id: taskId },
           success: function(response){
    if(response === 'success') {
        // Ubah badge
        const card = button.closest('.task-card');
        card.find('.badge')
            .removeClass('bg-warning bg-danger')
            .addClass('bg-success')
            .text('Completed');

        // Ubah status indicator
        card.find('.status-indicator')
            .removeClass('status-in_progress status-pending')
            .addClass('status-completed');

        // Sembunyikan tombol centang
        button.remove();
    } else {
        alert('Gagal menyelesaikan tugas.');
    }
}
        });
    });
});
</script>

<style>
  :root {
    --primary-color: #18327e;
    --primary-hover: #142b6b;
    --success-light: rgba(24, 154, 70, 0.15);
    --warning-light: rgba(255, 193, 7, 0.15);
    --danger-light: rgba(231, 74, 59, 0.15);
  }
  
  * {
    box-sizing: border-box;
  }
  
  body {
    background-color: #f8f9fa;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    padding-bottom: 60px; /* Space for floating button */
  }

  .container {
    padding: 0 15px;
    max-width: 100%;
  }

  h4 {
    color: var(--primary-color);
    font-weight: 600;
    margin: 15px 0;
    font-size: 1.3rem;
  }

  /* Floating Action Button */
  .fab {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background-color: var(--primary-color);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    z-index: 1000;
    border: none;
    font-size: 24px;
    transition: all 0.3s;
  }
  
  .fab:hover {
    background-color: var(--primary-hover);
    transform: scale(1.1);
  }

  /* Task Cards */
  .task-card {
    border-radius: 12px;
    background-color: #fff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    margin-bottom: 12px;
    border: none;
    overflow: hidden;
    transition: all 0.2s;
  }
  
  .task-card:active {
    transform: scale(0.98);
  }

  .task-card-body {
    padding: 16px;
  }

  .task-title {
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 6px;
    color: #333;
    word-break: break-word;
  }

  .task-description {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 10px;
    word-break: break-word;
  }

  .task-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    align-items: center;
    margin-top: 12px;
  }

  .task-deadline {
    font-size: 0.85rem;
    color: #666;
    display: flex;
    align-items: center;
  }
  
  .task-deadline i {
    margin-right: 5px;
    font-size: 0.9rem;
  }

  .badge {
    padding: 6px 12px;
    font-weight: 500;
    font-size: 0.75rem;
    border-radius: 12px;
    text-transform: capitalize;
    min-width: 80px;
    text-align: center;
  }

  .bg-success {
    background-color: var(--success-light) !important;
    color: #189a46 !important;
  }

  .bg-warning {
    background-color: var(--warning-light) !important;
    color: #b38400 !important;
  }

  .bg-danger {
    background-color: var(--danger-light) !important;
    color: #b92e1e !important;
  }

  /* Action Buttons */
  .task-actions {
    display: flex;
    gap: 8px;
    margin-top: 12px;
  }

  .task-btn {
    flex: 1;
    padding: 8px 0;
    border-radius: 8px;
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    border: none;
  }
  
  .task-btn i {
    font-size: 0.9rem;
  }

  .btn-info {
    background-color: rgba(24, 70, 154, 0.1);
    color: var(--primary-color);
  }

  .btn-danger {
    background-color: rgba(231, 74, 59, 0.1);
    color: #b92e1e;
  }

  .btn-success {
    background-color: var(--success-light);
    color: #189a46;
  }

  /* Swipe actions (optional) */
  .task-container {
    position: relative;
  }
  
  .swipe-actions {
    position: absolute;
    top: 0;
    right: 0;
    height: 100%;
    display: flex;
    align-items: center;
    padding-right: 15px;
    background: linear-gradient(90deg, transparent 0%, #f8f9fa 20%);
  }

  /* Status indicator */
  .status-indicator {
    width: 8px;
    height: 100%;
    position: absolute;
    left: 0;
    top: 0;
  }
  
  .status-completed {
    background-color: #189a46;
  }
  
  .status-in_progress {
    background-color: #ffc107;
  }
  
  .status-pending {
    background-color: #b92e1e;
  }

  /* Empty state */
  .empty-state {
    text-align: center;
    padding: 40px 20px;
    color: #999;
  }
  
  .empty-state i {
    font-size: 3rem;
    margin-bottom: 15px;
    color: #ddd;
  }

  /* Responsive adjustments */
  @media (min-width: 768px) {
    .container {
      max-width: 750px;
      margin: 0 auto;
    }
    
    .task-actions {
      margin-top: 0;
      justify-content: flex-end;
    }
    
    .task-btn {
      flex: 0 0 auto;
      padding: 8px 12px;
    }
  }
</style>

<!-- Mobile-friendly Task List -->
  <div class="container">
 <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Tugas</h4>
        <!-- Mobile-friendly Add Button that shows on smaller screens -->
        <a href="add_task.php" class="btn btn-primary btn-add-mobile d-md-none">
            <i class="fas fa-plus"></i>
        </a>
        <!-- Regular Add Button that shows on larger screens -->
        <a href="add_task.php" class="btn btn-primary d-none d-md-inline-flex align-items-center">
            <i class="fas fa-plus me-2"></i>
            <span>Tambah Tugas</span>
        </a>
    </div>


  <?php if (empty($tasks)): ?>
    <div class="empty-state">
      <i class="fas fa-tasks"></i>
      <h5>Tidak ada tugas</h5>
      <p>Tambahkan tugas baru dengan menekan tombol + di bawah</p>
    </div>
  <?php else: ?>
  <?php foreach ($tasks as $task): ?>
  <div class="task-container">
    <div class="task-card">
      <div class="status-indicator status-<?= $task['status'] ?>"></div>
      <div class="task-card-body">
        <div class="task-title"><?= htmlspecialchars($task['title']) ?></div>
        <div class="task-description"><?= htmlspecialchars($task['description']) ?></div>

      <div class="task-meta">
  <div class="task-deadline">
    <i class="far fa-calendar-alt"></i>
    <?= date('d M Y', strtotime($task['deadline'])) ?>
  </div>
 <span class="badge 
  <?php
    if ($task['status'] === 'not_started') {
      echo 'bg-danger';
    } elseif ($task['status'] === 'completed') {
      echo 'bg-success';
    } else {
      echo 'bg-' . ($badge_class[$task['status']] ?? 'secondary');
    }
  ?>">
  <?php
    if ($task['status'] === 'not_started') {
      echo 'Belum';
    } elseif ($task['status'] === 'completed') {
      echo 'Selesai';
    } else {
      echo $status_text[$task['status']] ?? ucfirst($task['status']);
    }
  ?>
</span>

</div>



        <!-- Responsif Action Buttons -->
        <div class="task-actions d-flex flex-column flex-md-row mt-3 gap-2">
          <!-- Tombol hapus -->
          <a href="delete_task.php?id=<?= $task['id'] ?>" class="task-btn btn-danger text-center">
            <i class="fas fa-trash"></i>
            <span class="d-none d-md-inline">Hapus</span>
          </a>

          <!-- Tombol selesai / undo -->
          <form action="update_task_status.php" method="POST" class="d-inline w-100 w-md-auto">
            <input type="hidden" name="id" value="<?= $task['id'] ?>">
            <input type="hidden" name="action" value="<?= $task['status'] == 'completed' ? 'undo' : 'complete' ?>">
            <button type="submit" class="task-btn btn-<?= $task['status'] == 'completed' ? 'info' : 'success' ?> w-100 text-center">
              <i class="fas <?= $task['status'] == 'completed' ? 'fa-undo' : 'fa-check' ?>"></i>
              <span class="d-none d-md-inline"><?= $task['status'] == 'completed' ? 'Undo' : 'Selesai' ?></span>
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>


  <?php endif; ?>
</div>
</div>
<?php require_once 'includes/footer.php'; ?>