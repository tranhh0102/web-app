<?php

namespace App\Http\Controllers;

use App\Models\CharityTransaction;
use App\Models\Expense;
use App\Models\Goal;
use App\Models\GoalTransaction;
use App\Models\Income;
use App\Models\Statistic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');
        $data = Statistic::where('user_id',$userId)->where('month', $month)->where('year', $year)->first();
        $dataExpenses = Expense::where('user_id',$userId)->whereBetween('date', [Carbon::now()->firstOfMonth(),Carbon::now()->lastOfMonth()])->orderBy('date', 'desc')->get();
        $dataIncomes = Income::where('user_id',$userId)->whereBetween('date', [Carbon::now()->firstOfMonth(),Carbon::now()->lastOfMonth()])->orderBy('date', 'desc')->get();
        $now = Carbon::now(); // Lấy thời gian hiện tại
        $today = Carbon::today();
        $user = Auth::user();
        
        $hasExpenseForToday = false;
        
        // Chỉ kiểm tra sau 8 giờ tối
        if ($now->hour >= 20) {
            $hasExpenseForToday = $user->expenses()->whereDate('created_at', $today)->exists();
        }

        $titlePage = 'Tháng ' . Carbon::now()->format('m - Y');

        return view('pages.home',compact('dataExpenses','dataIncomes','data','hasExpenseForToday', 'titlePage'));
    }

    public function idea()
    {
        $titlePage = 'Khuyến nghị chi tiêu';
        return view('pages.idea',compact('titlePage'));
    }

    public function ideaPlan(Request $request)
    {
        $titlePage = 'Khuyến nghị chi tiêu';
        //Tao plan chi tieu
        $planData = [];
        $charge = $request->get('charge');
        switch ((int) $request->get('type')) {
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
        return view('pages.idea_plan',compact('titlePage', 'planData', 'typeName'));
    }

    public function listSearch(Request $request)
    {
        $userId = auth()->user()->id;
        $search = $request->input('search'); // Từ khóa tìm kiếm
        $date = $request->input('date'); // Lọc theo ngày
    
        // Lấy danh sách chi tiêu và thu nhập theo user_id
        $dataExpenses = Expense::where('user_id', $userId);
        $dataIncomes = Income::where('user_id', $userId);
    
        // Nếu có từ khóa tìm kiếm, lọc theo tên hoặc mô tả
        if (!empty($search)) {
            $dataExpenses->where(function($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            });
    
            $dataIncomes->where(function($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            });
        }
    
        // Nếu có lọc theo ngày, tìm theo cột created_at hoặc date
        if (!empty($date)) {
            $dataExpenses->whereDate('created_at', $date);
            $dataIncomes->whereDate('created_at', $date);
        }
    
        // Lấy dữ liệu
        $dataExpenses = $dataExpenses->orderBy('date', 'desc')->get();
        $dataIncomes = $dataIncomes->orderBy('date', 'desc')->get();
    
        // Gộp danh sách chi tiêu và thu nhập
        $data = $dataExpenses->concat($dataIncomes);
        
        return view('pages.home-search', compact('data'));
    }
    
}
