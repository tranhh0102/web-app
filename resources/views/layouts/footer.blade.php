<div class="navbar">
    <a href="{{route('home')}}" class="nav-button">
        <img src="{{asset('svg/home.svg')}}" alt="">
    </a>
    <a class="nav-button">
        <img src="{{asset('svg/schedule.svg')}}" alt="">
    </a>
    <a href="{{route('add-expenses')}}" id="floatingButton"  class="add-button">+</a>
    <a class="nav-button">
        <img src="{{asset('svg/report.svg')}}" alt="">
    </a>
    <a href="{{route('profile.edit')}}" class="nav-button">
        <img src="{{asset('svg/profile.svg')}}" alt="">
    </a>
</div>

<style>
    .add-button {
        position: fixed;
        bottom: 100px;
        right: 20px;
        width: 60px;
        height: 60px;
        background-color: rgba(0, 123, 255, 0.8);
        color: white;
        font-size: 32px;
        font-weight: bold;
        text-align: center;
        line-height: 60px;
        border-radius: 50%;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
        cursor: grab;
        text-decoration: none;
        user-select: none;
        z-index: 999;
        transition: all 0.3s ease-in-out;
    }

    .add-button:active {
        cursor: grabbing;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const button = document.getElementById("floatingButton");
        let offsetX, offsetY, isDragging = false;

        function onMove(e) {
            if (!isDragging) return;

            let clientX = e.clientX || e.touches[0].clientX;
            let clientY = e.clientY || e.touches[0].clientY;

            let x = clientX - offsetX;
            let y = clientY - offsetY;

            // Giới hạn di chuyển trong màn hình
            let maxX = window.innerWidth - button.offsetWidth;
            let maxY = window.innerHeight - button.offsetHeight;

            x = Math.max(0, Math.min(x, maxX));
            y = Math.max(0, Math.min(y, maxY));

            button.style.left = `${x}px`;
            button.style.top = `${y}px`;
        }

        function onEnd() {
            if (!isDragging) return;
            isDragging = false;

            let buttonRect = button.getBoundingClientRect();
            let centerX = buttonRect.left + buttonRect.width / 2;
            let screenWidth = window.innerWidth;

            // Dính vào cạnh trái hoặc phải
            if (centerX < screenWidth / 2) {
                button.style.left = "10px"; // Dính vào cạnh trái
            } else {
                button.style.left = `${screenWidth - button.offsetWidth - 10}px`; // Dính vào cạnh phải
            }

            button.style.transition = "all 0.3s ease-in-out";
        }

        function onStart(e) {
            isDragging = true;
            button.style.transition = "none";

            let clientX = e.clientX || e.touches[0].clientX;
            let clientY = e.clientY || e.touches[0].clientY;

            offsetX = clientX - button.getBoundingClientRect().left;
            offsetY = clientY - button.getBoundingClientRect().top;
        }

        // Desktop events
        button.addEventListener("mousedown", onStart);
        document.addEventListener("mousemove", onMove);
        document.addEventListener("mouseup", onEnd);

        // Mobile events
        button.addEventListener("touchstart", onStart);
        document.addEventListener("touchmove", onMove);
        document.addEventListener("touchend", onEnd);
    });
</script>
