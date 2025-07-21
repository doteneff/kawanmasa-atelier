<?= $this->extend('layouts/header') ?>

<?= $this->section('head') ?>
<style>
    .main-layout {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding-top: 0;
    }
    .container-card {
        background: #fff;
        border-radius: 1.25rem;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.1);
        padding: 2.5rem;
        max-width: 700px;
        margin: auto;
        height: 650px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .appointment-title {
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 2rem;
      color: #232136;
    }
    .appointment-list {
      display: flex;
      flex-direction: column;
      gap: 1.2rem;
    }
    .appointment-item {
      display: flex;
      align-items: center;
      border-radius: 1rem;
      box-shadow: 0 4px 24px rgba(0, 0, 0, 0.1);
      padding: 1.2rem 2rem;
      gap: 2rem;
      color: #fff;
      background: #232136;
    }
    .appointment-item.unreviewed {
      background: #fff;
      color: #232136;
      border: 1.5px solid #a78bfa;
    }
    .appointment-date {
      font-size: 2.5rem;
      font-weight: 700;
    }
    .appointment-date-pipe {
      font-size: 1.8rem;
      font-weight: 400;
      color: #a78bfa;
      margin: 0 0.7rem;
    }
    .appointment-session {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      min-width: 90px;
    }
    .appointment-session-monthyear,
    .appointment-session-time {
      color: #a78bfa;
      font-weight: 600;
    }
    .appointment-session-monthyear {
      font-size: 1.1rem;
      margin-bottom: 0.2rem;
    }
    .appointment-session-time {
      font-size: 1.2rem;
      font-weight: 700;
    }
    .appointment-item.unreviewed .appointment-session-monthyear,
    .appointment-item.unreviewed .appointment-session-time {
      color: #7c3aed;
    }
    .appointment-status {
      margin-left: auto;
      margin-right: 1.5rem;
      font-size: 1.1rem;
      font-weight: 600;
      min-width: 110px;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
    }
    .appointment-status.unreviewed {
      color: #a78bfa;
    }
    .review-btn {
      background: #7c3aed;
      color: #fff;
      border: none;
      border-radius: 0.5rem;
      padding: 0.7rem 1.3rem;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.2s, transform 0.1s;
      text-decoration: none;
      display: inline-block;
      min-width: 120px;
      text-align: center;
    }
    .review-btn:hover {
      background: #a78bfa;
      transform: scale(1.03);
    }
    .review-btn.disabled {
      background: #a78bfa;
      color: #fff;
      cursor: not-allowed;
      pointer-events: none;
      opacity: 0.7;
      transform: none;
    }
    .no-appointments {
      text-align: center;
      color: #a78bfa;
      font-size: 1.2rem;
      margin-top: 2rem;
    }
    .appointment-pagination {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }
    .appointment-pagination ul {
        display: flex;
        gap: 0.5rem;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .appointment-pagination li {
        display: flex;
    }
    .appointment-pagination a,
    .appointment-pagination span {
        background: #a78bfa;
        color: #fff;
        border-radius: 0.5rem;
        padding: 0.6rem 1.2rem;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.2s, transform 0.1s;
        display: inline-block;
        min-width: 40px;
        text-align: center;
        margin: 0 2px;
        border: none;
    }
    .appointment-pagination a:hover {
        background: #7c3aed;
        transform: scale(1.05);
    }
    .appointment-pagination .active span,
    .appointment-pagination .active {
        background: #7c3aed;
        color: #fff;
        cursor: default;
        font-weight: 700;
        pointer-events: none;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
  <div class="main-layout">
    <div class="container-card">
      <div class="appointment-title">My Appointments</div>
      <div class="appointment-list">
        <?php if (!empty($appointments)): ?>
            <?php foreach ($appointments as $appointment): 
                $dt = new DateTime($appointment['date'] . ' ' . $appointment['time']);
                $day = $dt->format('d');
                $monthYear = $dt->format('F Y');
                $time = $dt->format('H:i');
                $isPending = ($appointment['status'] === 'pending') ? true : false;
                $isReviewed = !empty($appointment['has_review']);
                $isUnreviewed = !$isReviewed;
            ?>
                <div class="appointment-item <?= $isUnreviewed ? 'unreviewed' : '' ?>">
                    <div class="appointment-date"><?= $day ?></div>
                    <div class="appointment-date-pipe">|</div>
                    <div class="appointment-session">
                        <div class="appointment-session-monthyear"><?= $monthYear ?></div>
                        <div class="appointment-session-time"><?= $time ?></div>
                    </div>
                    <div class="appointment-status <?= $isUnreviewed ? 'unreviewed' : 'reviewed' ?>">
                        <?= $isReviewed ? 'Reviewed' : 'Unreviewed' ?>
                    </div>
                    <a class="review-btn<?= $isPending ? ' disabled' : '' ?>" href="<?= $isPending ? '#' : "/review/" . ($isReviewed ? 'view' : 'write') . "/{$appointment['id']}" ?>">
                        <?= $isReviewed ? 'View Review' : 'Write Review' ?>
                    </a>
                </div>
            <?php endforeach; ?>

            <div class="appointment-pagination">
                <?= $pager->simpleLinks('appointments', 'default_simple') ?>
            </div>
        <?php else: ?>
            <div class="no-appointments">
                You haven't made any appointments. Book a schedule first!
            </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
<?= $this->endSection() ?>
