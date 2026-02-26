<?php

class WishlistController extends Controller
{
    private $wishlist;

    public function __construct()
    {
        $this->wishlist = new Wishlist();
    }

    private function checkLogin()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }
    }

    public function index()
    {
        $this->checkLogin();

        $userId = $_SESSION['user']['id'];
        $items = $this->wishlist->getByUser($userId);

        return $this->view('wishlist.index', compact('items'));
    }

    public function add($id)
    {
        $this->checkLogin();

        $userId = $_SESSION['user']['id'];

        // Chỉ thêm nếu chưa tồn tại
        if (!$this->wishlist->isLiked($userId, $id)) {
            $this->wishlist->add($userId, $id);
        }

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function remove($id)
    {
        $this->checkLogin();

        $userId = $_SESSION['user']['id'];
        $this->wishlist->remove($userId, $id);

        header("Location: /wishlist");
        exit;
    }

    /**
     * Toggle yêu thích (thêm nếu chưa có, xóa nếu đã có)
     * Không ảnh hưởng add/remove cũ
     */
    public function toggle($id)
    {
        $this->checkLogin();

        $userId = $_SESSION['user']['id'];

        if ($this->wishlist->isLiked($userId, $id)) {
            $this->wishlist->remove($userId, $id);
        } else {
            $this->wishlist->add($userId, $id);
        }

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
}