<?php

namespace App\Http\Controllers;

use App\Models\CharityTransaction;
use App\Models\Expense;
use App\Models\Goal;
use App\Models\GoalTransaction;
use App\Models\Income;
use App\Models\MExpense;
use App\Models\MIncome;
use App\Models\Statistic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $currentDate = Carbon::now()->format('Y-m-d');
        $userId = auth()->user()->id;
        $selectedDate = $request->get('selected_date');
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');
        $defaultMonthYear = Carbon::now()->format('m / Y');
        if (!empty($selectedDate)) {
            $splitDate = explode('/', $selectedDate);
            $month = sprintf("%2d", (int) $splitDate[0]);
            $year = (int) $splitDate[1];
            $defaultMonthYear = $selectedDate;
        }
        $data = Statistic::where('user_id', $userId)->where('month', $month)->where('year', $year)->first();
        $dataExpenses = Expense::where('user_id', $userId)->whereBetween('date', [Carbon::now()->firstOfMonth(), Carbon::now()->lastOfMonth()])->orderBy('created_at', 'desc')->limit(4)->get();
        $dataIncomes = Income::where('user_id', $userId)->whereBetween('date', [Carbon::now()->firstOfMonth(), Carbon::now()->lastOfMonth()])->orderBy('created_at', 'desc')->limit(4)->get();
        $now = Carbon::now(); // Lấy thời gian hiện tại
        $today = Carbon::today();
        $user = Auth::user();

        $hasExpenseForToday = false;

        // Chỉ kiểm tra sau 8 giờ tối
        if ($now->hour >= 20) {
            $hasExpenseForToday = $user->expenses()->whereDate('created_at', $today)->exists();
        }

        $tabActive = $request->get('tab_active') ? $request->get('tab_active') : 'statistic';
        $extendClass = 'disable-scroll';
        return view('pages.home', compact('currentDate', 'extendClass', 'tabActive','dataExpenses', 'dataIncomes', 'data', 'hasExpenseForToday', 'defaultMonthYear'));
    }

    public function idea()
    {
        $titlePage = 'Khuyến nghị chi tiêu';
        return view('pages.idea', compact('titlePage'));
    }

    public function moneyPlan(Request $request)
    {
        $questions = [
            "Bạn thường làm gì khi nhận lương?",
            "Bạn có theo dõi chi tiêu không?",
            "Bạn chi tiêu bao nhiêu phần trăm thu nhập cho nhu cầu thiết yếu?",
            "Bạn có kế hoạch tiết kiệm?",
            "Khi gặp một món đồ yêu thích, bạn sẽ?",
            "Bạn có đặt mục tiêu tài chính dài hạn không?",
            "Bạn có sử dụng thẻ tín dụng không?",
            "Bạn có quỹ dự phòng khẩn cấp không?",
            "Bạn thường chi tiêu thế nào khi đi du lịch?",
            "Bạn có đầu tư để tăng thu nhập không?"
        ];
        
        $options = [
            ["Tiết kiệm trước, chi tiêu sau", "Lên kế hoạch chi tiêu", "Chi tiêu trước, tiết kiệm sau", "Tận hưởng ngay lập tức"],
            ["Theo dõi chặt chẽ", "Theo dõi sơ bộ", "Thỉnh thoảng theo dõi", "Không quan tâm"],
            ["Dưới 50%", "50-60%", "60-70%", "Trên 70%"],
            ["Tiết kiệm trên 30% thu nhập", "Tiết kiệm 20-30% thu nhập", "Chỉ tiết kiệm khi có dư", "Không tiết kiệm"],
            ["Suy nghĩ kỹ trước khi mua", "Cân nhắc rồi mua", "Mua ngay nếu có thể chi trả", "Thường xuyên mua sắm tùy hứng"],
            ["Có kế hoạch rõ ràng", "Đôi khi đặt mục tiêu", "Chỉ nghĩ khi có dư", "Không đặt mục tiêu"],
            ["Không dùng hoặc trả đủ mỗi tháng", "Chỉ dùng khi cần", "Dùng thường xuyên nhưng kiểm soát", "Dùng mà không quan tâm nợ"],
            ["Có quỹ dự phòng trên 6 tháng", "Có quỹ dự phòng 3-6 tháng", "Dưới 3 tháng", "Không có quỹ dự phòng"],
            ["Lập kế hoạch chi tiết", "Chi tiêu hợp lý", "Chi tiêu thoải mái", "Tiêu xài hết mức"],
            ["Đầu tư đều đặn", "Chỉ đầu tư khi có dư", "Rất ít đầu tư", "Không đầu tư"]
        ];


        return view('pages.money_plan_question', [
            'charge' => $request->get('charge'),
            'questions' => $questions,
            'options' => $options
        ]);
    }

    private function calculateMoneyPlanType($request)
    {
        $answers = $request->input('answers', []);
        $scoreA = $scoreB = $scoreC = 0;

        foreach ($answers as $answer) {
            if ($answer == 'a') {
                $scoreA++;
            } elseif ($answer == 'b') {
                $scoreB++;
            } else {
                $scoreC++;
            }
        }

        if ($scoreC > $scoreA && $scoreC > $scoreB) {
            return 1;
        } elseif ($scoreA > $scoreC && $scoreA > $scoreB) {
            return 2;
        } else {
            return 3;
        }
    }

    public function ideaPlan(Request $request)
    {
        $titlePage = 'Khuyến nghị chi tiêu';
        //Tao plan chi tieu
        $planData = [];
        $charge = $request->get('charge');
        $type = $this->calculateMoneyPlanType($request);
        switch ($type) {
            // Hưởng thụ thoải mái 
            case 1:
                $planData = [
                    'nhu_cau_co_ban' => $charge * 0.5,
                    'giai_tri' => $charge * 0.3,
                    'tiet_kiem' => $charge * 0.1,
                    'khac' => $charge * 0.1,
                    'note'  => 'Người muốn tận hưởng cuộc sống, không quá áp lực về tài chính, thu nhập đủ cao để đảm bảo nhu cầu.',
                    'advantage' => [
                        "Cuộc sống thoải mái, không bị gò bó tài chính.",
                        "Nhiều trải nghiệm thú vị, tận hưởng cuộc sống hiện tại.",
                        "Tạo động lực kiếm tiền vì có thể chi tiêu theo sở thích.",
                    ],
                    'disadvantage' => [
                        "Tiết kiệm ít, có thể gặp khó khăn khi có tình huống khẩn cấp.",
                        "Khả năng đạt được mục tiêu tài chính dài hạn thấp.",
                        "Dễ rơi vào vòng xoáy chi tiêu quá mức nếu không kiểm soát tốt.",
                    ]
                ];
                break;
            // Tiết kiệm tối đa
            case 2:
                $planData = [
                    'nhu_cau_co_ban' => $charge * 0.5,
                    'giai_tri' => $charge * 0.4,
                    'tiet_kiem' => $charge * 0.05,
                    'khac' => $charge * 0.05,
                    'note'  => 'Người muốn tối ưu tài chính, nhanh chóng đạt được mục tiêu tiết kiệm lớn hoặc độc lập tài chính sớm.',
                    'advantage' => [
                        "Tích lũy tài chính nhanh, đảm bảo tương lai ổn định.",
                        "Có thể đầu tư sinh lời sớm, đạt tự do tài chính nhanh hơn.",
                        "Luôn có quỹ dự phòng, ít lo lắng về tài chính trong khủng hoảng.",
                    ],
                    'disadvantage' => [
                        "Cuộc sống có thể bị gò bó, ít trải nghiệm giải trí, du lịch.",
                        "Dễ cảm thấy bị thắt lưng buộc bụng và thiếu động lực sống.",
                        "Nếu tiết kiệm quá mức, có thể bỏ lỡ nhiều cơ hội tận hưởng cuộc sống."
                    ]
                ];
                break;
            //Cân bằng
            default:
                $planData = [
                    'nhu_cau_co_ban' => $charge * 0.5,
                    'giai_tri' => $charge * 0.25,
                    'tiet_kiem' => $charge * 0.15,
                    'khac' => $charge * 0.1,
                    'note'  => 'Người muốn vừa có tài chính ổn định, vừa có thể tận hưởng cuộc sống mà không ảnh hưởng đến tương lai.',
                    'advantage' => [
                        "Giữ được sự ổn định tài chính và vẫn có thể tận hưởng cuộc sống.",
                        "Có cả quỹ tiết kiệm lẫn ngân sách giải trí hợp lý.",
                        "Dễ duy trì lâu dài mà không cảm thấy áp lực.",
                    ],
                    'disadvantage' => [
                        "Tích lũy tài chính chậm hơn so với kế hoạch tiết kiệm tối đa.",
                        "Nếu thu nhập thấp, có thể cảm thấy chưa đủ linh hoạt.",
                        "Cần kỷ luật để không lấn sang khoản chi tiêu khác.",
                    ]
                ];
                break;
        }
        $typeName = ((int) $request->get('type') == 1) ? 'Tận hưởng cuộc sống' : (((int) $request->get('type') == 2) ? 'Tối ưu tài chính' : 'Tận hưởng và tối ưu tài chính');
        return view('pages.idea_plan', compact('titlePage', 'planData', 'typeName'));
    }

    public function listSearch(Request $request)
    {
        $userId = auth()->user()->id;
        $type = $request->input('type') ?? null;
        $search = $request->input('search');
        $date = $request->input('date');
        $expenseCategoryFilter = $request->input('expense_category');
        $incomeCategoryFilter = $request->input('income_category');
    
        // Lấy danh mục chi tiêu và thu nhập
        $mExpenses = MExpense::where('user_id', $userId)->get();
        $mIncomes = MIncome::where('user_id', $userId)->get();
    
        // Khởi tạo danh sách rỗng
        $dataExpenses = collect();
        $dataIncomes = collect();
    
        // Nếu có lọc theo danh mục chi tiêu hoặc không có chọn danh mục nào, lấy dữ liệu chi tiêu
        if ($type == 'expense' || !$type) {
            if (!empty($expenseCategoryFilter) || (empty($expenseCategoryFilter) && empty($incomeCategoryFilter))) {
                $queryExpenses = Expense::where('user_id', $userId);
        
                // Nếu có từ khóa tìm kiếm, lọc theo tên
                if (!empty($search)) {
                    $queryExpenses->where('name', 'like', "%$search%");
                }
        
                // Nếu có lọc theo ngày
                if (!empty($date)) {
                    $queryExpenses->whereDate('created_at', $date);
                }
        
                // Nếu có lọc theo danh mục chi tiêu
                if (!empty($expenseCategoryFilter)) {
                    $queryExpenses->where('m_expense_id', $expenseCategoryFilter);
                }
        
                // Lấy danh sách chi tiêu
                $dataExpenses = $queryExpenses->orderBy('date', 'desc')->get()->map(function ($item) {
                    $item->type = 'expense';
                    return $item;
                });
            }
        }
    
        // Nếu có lọc theo danh mục thu nhập hoặc không có chọn danh mục nào, lấy dữ liệu thu nhập
        if ($type == 'income' || !$type) {
            if (!empty($incomeCategoryFilter) || (empty($expenseCategoryFilter) && empty($incomeCategoryFilter))) {
                $queryIncomes = Income::where('user_id', $userId);
        
                // Nếu có từ khóa tìm kiếm, lọc theo tên
                if (!empty($search)) {
                    $queryIncomes->where('name', 'like', "%$search%");
                }
        
                // Nếu có lọc theo ngày
                if (!empty($date)) {
                    $queryIncomes->whereDate('created_at', $date);
                }
        
                // Nếu có lọc theo danh mục thu nhập
                if (!empty($incomeCategoryFilter)) {
                    $queryIncomes->where('m_income_id', $incomeCategoryFilter);
                }
        
                // Lấy danh sách thu nhập
                $dataIncomes = $queryIncomes->orderBy('date', 'desc')->get()->map(function ($item) {
                    $item->type = 'income';
                    return $item;
                });
            }
        }
    
        // Gộp danh sách thu nhập & chi tiêu
        $data = $dataExpenses->concat($dataIncomes);
        $extendClass = 'disable-scroll';
        return view('pages.home-search', compact('type', 'extendClass', 'data', 'mExpenses', 'mIncomes'));
    }
    
}
