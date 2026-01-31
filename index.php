<?php
/**
 * نظام FIRST PRDCRUD - النسخة الفاخرة (Ultimate Luxury Edition)
 * واجهة موحدة متكاملة بأعلى معايير التصميم
 */

require_once 'includes/db.php';
require_once 'includes/functions.php';

// معالجة الإضافة السريعة
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'create') {
    $name = sanitize($_POST['name']);
    $price = sanitize($_POST['price']);
    $description = sanitize($_POST['description']);
    
    if (!empty($name) && is_numeric($price)) {
        if (create_product($conn, $name, $price, $description)) {
            $_SESSION['flash_success'] = "مبروك! تم تسجيل المنتج بنجاح في النظام.";
            redirect("index.php");
        }
    }
}

$products = get_all_products($conn);
include 'includes/header.php';
?>

<div class="luxury-container fade-up">
    <!-- رأس الصفحة السينمائي -->
    <div class="row mb-5 align-items-end">
        <div class="col-md-8">
            <h1 class="display-3 fw-bolder mb-3 ls-tighter">إدارة المنتجات</h1>
            <p class="text-secondary fs-5 mb-0">تحكم كامل في مخزونك التجاري من خلال واجهة ذكية واحدة.</p>
        </div>
        <div class="col-md-4 text-start text-md-end mt-4">
            <button class="btn btn-primary btn-lg px-5 shadow-lg" onclick="toggleHeroForm()">
                منتج جديد
            </button>
        </div>
    </div>

    <!-- فورم الإضافة المبتكر -->
    <div id="addFormWrapper" class="hidden mb-60">
        <div class="product-list-card border-glow">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h2 class="h3 fw-bold text-white mb-0">إضافة قطعة جديدة للمخزن</h2>
                <button class="btn btn-outline-danger btn-sm px-3" onclick="toggleHeroForm()">إلغاء</button>
            </div>
            <form action="index.php" method="POST" id="mainEntryForm">
                <input type="hidden" name="action" value="create">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label text-secondary fw-bold ms-2">اسم المنتج</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="مثلاً: ماك بوك برو..." required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary fw-bold ms-2">السعر التجاري ($)</label>
                        <input type="number" step="0.01" name="price" id="price" class="form-control" placeholder="0.00" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label text-secondary fw-bold ms-2">شرح مختصر عن المنتج</label>
                        <textarea name="description" id="description" rows="4" class="form-control" placeholder="أدخل تفاصيل ومواصفات المنتج هنا..."></textarea>
                    </div>
                    <div class="col-12 text-end mt-5">
                        <button type="submit" class="btn btn-primary px-5 py-3 fs-5">تأكيد الإضافة والارسال</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- شريط البحث الفاخر -->
    <div class="search-box">
        <input type="text" id="masterSearch" class="form-control search-field" placeholder="ابحث عن أي منتج بلمسة واحدة...">
    </div>

    <!-- قائمة المنتجات بنظام الكروت المدمجة -->
    <div class="product-list-card overflow-hidden p-0">
        <div class="table-header d-none d-md-grid">
            <div>المعرف</div>
            <div>اسم القطعة</div>
            <div>القيمة</div>
            <div class="text-end ms-4">التحكم</div>
        </div>

        <div id="productDataGrid">
            <?php if ($products && $products->num_rows > 0): ?>
                <?php while($row = $products->fetch_assoc()): ?>
                    <div class="product-row fade-up" style="animation-delay: 0.1s;">
                        <div class="text-muted fw-bold">#<?php echo $row['id']; ?></div>
                        <div>
                            <span class="fs-5 fw-bold text-white"><?php echo sanitize($row['name']); ?></span>
                            <div class="d-md-none text-muted small mt-1">السعر: $<?php echo number_format($row['price'], 2); ?></div>
                        </div>
                        <div class="text-accent-gold fw-bolder fs-5 d-none d-md-block">$<?php echo number_format($row['price'], 2); ?></div>
                        <div class="text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm px-4 btn-custom-edit">تعديل</a>
                                <button class="btn btn-outline-danger btn-sm px-4" 
                                        onclick="requestCinemaDelete('<?php echo addslashes(sanitize($row['name'])); ?>', 'delete.php?id=<?php echo $row['id']; ?>')">
                                    حذف
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="text-center py-5">
                    <h4 class="text-muted py-5">المخزن فارغ حالياً.. ابدأ بإضافة منتجاتك.</h4>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php 
// إدارة شاشة النجاح السينمائية
if (isset($_SESSION['flash_success'])) {
    $msg = $_SESSION['flash_success'];
    echo "<script>document.addEventListener('DOMContentLoaded', () => revealCinemaSuccess('$msg'));</script>";
    unset($_SESSION['flash_success']);
}
include 'includes/footer.php'; 
?>
