<?
namespace App\Controller;

use App\Repository\CustomerRepository;
use App\Repository\OrderRepository;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/report')]
class ReportController extends AbstractController
{
    #[Route('/', name: 'report_index')]
public function index(
    CustomerRepository $customerRepo,
    OrderRepository $orderRepo,
    BookRepository $bookRepo
): Response
{
    $customersWithOrderCount = $customerRepo->findCustomerOrderCounts();
    $top3Customers = $customerRepo->findTop3CustomersByTotalSpent();
    $averageOrderTotal = $orderRepo->findAverageOrderTotal();
    $mostExpensiveBook = $bookRepo->findMostExpensiveBook();

    $recentOrders = $orderRepo->findRecentOrdersWithCustomer();

    return $this->render('report/index.html.twig', [
        'customersWithOrderCount' => $customersWithOrderCount,
        'top3Customers' => $top3Customers,
        'averageOrderTotal' => $averageOrderTotal,
        'mostExpensiveBook' => $mostExpensiveBook,
        'recentOrders' => $recentOrders,
    ]);
}
}