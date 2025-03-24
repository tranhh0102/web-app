<div class="navbar">
    <!--Statistic-->
    <a href="{{route('home')}}" class="nav-button">
        <img src="{{asset('svg/home.svg')}}" alt="">
        <p class="name-button">Trang chủ</p>
    </a>

    <!--Search-->
    <a href="{{route('home-search')}}" class="nav-button">
        <img src="{{asset('svg/search.svg')}}" alt="">
        <p class="name-button">Tìm kiếm</p>
    </a>

    <div class="floating-container">
        <a id="floatingButton" class="add-button">+</a>
        <div id="actionButtons" class="action-buttons">
            <a href="{{route('transaction.add-expense')}}" class="action-button">
                <img style="width: 32px; height: 32px;" src="{{asset('svg/home/expense.svg')}}" alt="">
            </a>
            <a href="{{route('transaction.add-income')}}" class="action-button">
                <img style="width: 32px; height: 32px;" src="{{asset('svg/home/income.svg')}}" alt="">
            </a>
            <a href="{{route('transaction.add-charity')}}" class="action-button">
                <img style="width: 32px; height: 32px;" src="{{asset('svg/home/charity.svg')}}" alt="">
            </a>
            <a href="{{route('transaction.add-goal')}}" class="action-button">
                <img style="width: 32px; height: 32px;" src="{{asset('svg/home/goal.svg')}}" alt="">
            </a>
            <a href="{{route('idea')}}" class="action-button">
                <img style="width: 32px; height: 32px;" src="{{asset('svg/home/idea.svg')}}" alt="">
            </a>
        </div>
    </div>

    <!--Goal-->
    <a href="{{route('list-goal')}}" class="nav-button">
        <img src="{{asset('svg/goal.svg')}}" alt="">
        <p class="name-button">Mục tiêu</p>
    </a>

    <!--Charity-->
    <a href="{{route('list-charity')}}" class="nav-button">
        <img src="{{asset('svg/charity.svg')}}" alt="">
        <p class="name-button">Cộng đồng</p>
    </a>
    
    <!--Profile-->
    <a href="{{route('profile.edit')}}" class="nav-button">
        <img src="{{asset('svg/profile.svg')}}" alt="">
        <p class="name-button">Tài khoản</p>
    </a>
</div>

<style>
.floating-container {
position: fixed;
bottom: 130px;
right: 20px;
z-index: 999;
}

.add-button {
    width: 40px;
    height: 40px;
    background-color: #ff6b5e;
    color: white;
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    line-height: 60px;
    border-radius: 50%;
    box-shadow: 0 5px 15px rgba(255, 107, 94, 0.5);
    cursor: grab;
    text-decoration: none;
    user-select: none;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    z-index: 10;
}

.action-buttons {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    display: none; /* Mặc định ẩn */
    flex-direction: column;
    gap: 10px;
    display: none;
    width: 50px;
    background: white;
    border-radius: 10px;
    border: 1.5px solid #EF9651;
    padding: 10px;
    padding-left: 8px;
    padding-bottom: 0;
}

.action-buttons.active {
    display: flex;
}

.action-button {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s ease-in-out;
}
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("floatingContainer");
    const button = document.getElementById("floatingButton");
    const actionButtons = document.getElementById("actionButtons");


    button.addEventListener("click", function (e) {
        e.stopPropagation(); // Ngăn chặn sự kiện click lan ra ngoài
        actionButtons.classList.toggle("active");
    });

    document.addEventListener("click", function (e) {
        if (!e.target.closest("#floatingContainer")) {
            actionButtons.classList.remove("active"); // Ẩn menu khi bấm ra ngoài
        }
    });
});

</script>
