<?= $this->extend('layouts/header') ?>

<?= $this->section('head') ?>
<style>
    .review-card {
        background: #fff;
        border-radius: 1.25rem;
        box-shadow: 0 4px 24px rgba(0,0,0,0.10);
        padding: 2.5rem 2.5rem 2rem 2.5rem;
        max-width: 430px;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: stretch;
    }
    .review-title {
        font-size: 1.45rem;
        font-weight: 700;
        color: #232136;
        margin-bottom: 0.3rem;
    }
    .review-subtitle {
        font-size: 1.08rem;
        font-weight: 600;
        color: #232136;
        margin-bottom: 2.2rem;
    }
    .appointment-info {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        margin-bottom: 1.2rem;
    }
    .appointment-datetime {
        font-size: 1.15rem;
        font-weight: 700;
        color: #7c3aed;
        background: #f6f6fb;
        border-radius: 0.5rem;
        padding: 0.3rem 1rem;
        margin-right: 0.7rem;
    }
    .appointment-pipe {
        font-size: 1.15rem;
        color: #a78bfa;
        font-weight: 700;
        margin: 0 0.5rem;
    }
    .appointment-time {
        font-size: 1.15rem;
        font-weight: 700;
        color: #232136;
        background: #f6f6fb;
        border-radius: 0.5rem;
        padding: 0.3rem 1rem;
    }
    .review-form {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 1.2rem;
    }
    .review-textarea {
        width: 100%;
        min-height: 300px;
        border-radius: 0.75rem;
        border: 1.5px solid #a78bfa;
        padding: 1rem;
        font-size: 1.1rem;
        font-family: inherit;
        resize: vertical;
        background: #f6f6fb;
        color: #232136;
        margin-bottom: 0;
        transition: border 0.2s;
        box-sizing: border-box;
    }
    .review-textarea:focus {
        border-color: #7c3aed;
        outline: none;
    }
    .review-btn {
        background: #a78bfa;
        color: #fff;
        border: none;
        border-radius: 0.5rem;
        padding: 0.8rem 2rem;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s, transform 0.1s;
        width: 100%;
    }
    .review-btn:hover {
        background: #7c3aed;
        transform: scale(1.03);
    }
    #customAlert {
        position: fixed;
        top: 2rem;
        left: 50%;
        transform: translateX(-50%);
        background: #a78bfa;
        color: #fff;
        border-radius: 0.5rem;
        padding: 1rem 2rem;
        font-weight: 600;
        box-shadow: 0 2px 8px 0 rgb(0 0 0 / 0.10);
        z-index: 100;
        text-align: center;
        display: none;
    }
    #customAlert.show {
        display: block;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div id="customAlert"></div>
<div class="review-card">
    <div class="review-title">Satisfied with your result?</div>
    <div class="review-subtitle">Tell us your experience!</div>
    <?php
        $dt = new DateTime($appointment["appointment_at"]);
        $date = $dt->format('d M Y');
        $time = $dt->format('H:i');
    ?>
    <div class="appointment-info">
        <span class="appointment-datetime"><?= $date ?></span>
        <span class="appointment-pipe">|</span>
        <span class="appointment-time"><?= $time ?></span>
    </div>
    <form method="post" action="<?= site_url('/review/' . $appointment['id'] . '/submit') ?>" class="review-form" id="reviewForm">
        <textarea 
            name="review" 
            class="review-textarea"
            placeholder="Write your review here..." 
            required
        ></textarea>
        <button type="submit" class="review-btn">Submit Review</button>
    </form>
</div>
<script>
const reviewForm = document.getElementById("reviewForm");
const customAlert = document.getElementById("customAlert");

reviewForm.addEventListener("submit", async function (e) {
    e.preventDefault();
    const submitBtn = reviewForm.querySelector("button[type='submit']");
    submitBtn.disabled = true;

    try {
        const response = await fetch(reviewForm.action, {
            method: 'POST',
            body: new FormData(reviewForm)
        });

        if (response.ok && response.redirected) {
            customAlert.textContent = "Review Submitted!";
            customAlert.classList.add("show");
            setTimeout(() => {
                window.location.href = response.url;
            }, 1000);
        } else {
            throw new Error('Failed to submit review');
        }
    } catch (err) {
        customAlert.textContent = "Failed to submit review.";
        customAlert.classList.add("show");
        customAlert.style.background = "#ef4444";
        setTimeout(() => {
            customAlert.classList.remove("show");
            customAlert.style.background = "#a78bfa";
            submitBtn.disabled = false;
        }, 2000);
    }
});
</script>
<?= $this->endSection() ?>