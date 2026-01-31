<?php
/**
 * ═══════════════════════════════════════════════════════════════
 * تعديل منتج - FIRST PRDCRUD Ultimate Edition
 * ═══════════════════════════════════════════════════════════════
 */

require_once 'includes/db.php';
require_once 'includes/functions.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) redirect("index.php");

$id = $_GET['id'];
$product = get_product_by_id($conn, $id);
if (!$product) redirect("index.php");

$errors = [];
$name = $product['name'];
$price = $product['price'];
$description = $product['description'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = sanitize($_POST['name']);
    $price = sanitize($_POST['price']);
    $description = sanitize($_POST['description']);

    if (empty($name)) $errors['name'] = "هذا الحقل مطلوب";
    if (empty($price) || !is_numeric($price)) $errors['price'] = "أدخل سعراً صحيحاً";

    if (empty($errors)) {
        if (update_product($conn, $id, $name, $price, $description)) {
            $_SESSION['flash_success'] = "تم تحديث بيانات المنتج بنجاح";
            redirect("index.php");
        }
    }
}

include 'includes/header.php';
?>

<div class="luxury-container fade-up">
    <!-- Page Header with Back Button -->
    <div class="row mb-5 align-items-center">
        <div class="col-md-8">
            <div class="d-flex align-items-center gap-3 mb-3">
                <a href="index.php" class="btn btn-secondary btn-sm px-4" style="border-radius: 15px;">
                    ← العودة
                </a>
                <div>
                    <h1 class="display-4 fw-bolder mb-2 ls-tighter">
                        تعديل المنتج
                    </h1>
                    <p class="text-secondary fs-5 mb-0">
                        المعرف: <span class="text-accent-gold">#<?php echo $id; ?></span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Form Card -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="glass-card fade-up" style="animation-delay: 0.2s;">
                <!-- Card Header -->
                <div class="mb-5 pb-4 border-bottom-light">
                    <h2 class="h3 fw-bold text-white mb-2">تحديث معلومات المنتج</h2>
                    <p class="text-secondary mb-0">قم بتعديل البيانات أدناه ثم احفظ التغييرات</p>
                </div>

                <!-- Form -->
                <form action="" method="POST" id="productEditForm">
                    <div class="row g-4">
                        <!-- Product Name -->
                        <div class="col-12">
                            <label class="form-label text-secondary fw-bold ms-2">
                                اسم المنتج
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                class="form-control <?php echo isset($errors['name']) ? 'is-invalid' : ''; ?>" 
                                value="<?php echo sanitize($name); ?>"
                                placeholder="أدخل اسم المنتج..."
                                required
                            >
                            <?php if (isset($errors['name'])): ?>
                                <div class="invalid-feedback d-block mt-2 ms-2 text-danger-light">
                                    <?php echo $errors['name']; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Product Price -->
                        <div class="col-md-6">
                            <label class="form-label text-secondary fw-bold ms-2">
                                السعر التجاري ($)
                            </label>
                            <input 
                                type="number" 
                                step="0.01" 
                                name="price" 
                                id="price" 
                                class="form-control <?php echo isset($errors['price']) ? 'is-invalid' : ''; ?>" 
                                value="<?php echo sanitize($price); ?>"
                                placeholder="0.00"
                                required
                            >
                            <?php if (isset($errors['price'])): ?>
                                <div class="invalid-feedback d-block mt-2 ms-2 text-danger-light">
                                    <?php echo $errors['price']; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Product ID (Read-only) -->
                        <div class="col-md-6">
                            <label class="form-label text-secondary fw-bold ms-2">
                                المعرف الفريد
                            </label>
                            <input 
                                type="text" 
                                class="form-control" 
                                value="#<?php echo $id; ?>"
                                disabled
                                class="form-control bg-disabled"
                            >
                        </div>

                        <!-- Product Description -->
                        <div class="col-12">
                            <label class="form-label text-secondary fw-bold ms-2">
                                وصف المنتج
                            </label>
                            <textarea 
                                name="description" 
                                id="description" 
                                rows="5" 
                                class="form-control"
                                placeholder="أدخل تفاصيل ومواصفات المنتج..."
                            ><?php echo sanitize($description); ?></textarea>
                        </div>

                        <!-- Action Buttons -->
                        <div class="col-12 mt-5">
                            <div class="d-flex gap-3 justify-content-end">
                                <a href="index.php" class="btn btn-secondary px-5 py-3 fs-5">
                                    إلغاء
                                </a>
                                <button type="submit" class="btn btn-primary px-5 py-3 fs-5">
                                    💾 حفظ التغييرات
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Info Card -->
            <div class="glass-card mt-4 fade-up bg-accent-faint" style="animation-delay: 0.4s;">
                <div class="d-flex align-items-start gap-3">
                    <div>
                        <h5 class="fw-bold text-white mb-2">نصيحة احترافية</h5>
                        <p class="text-secondary mb-0">
                            تأكد من صحة البيانات قبل الحفظ. يمكنك استخدام 
                            <kbd class="kbd-custom">Ctrl + S</kbd>
                            للحفظ السريع.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Keyboard Shortcut for Save -->
<script>
document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        document.getElementById('productEditForm').submit();
    }
});

// Add animation to form inputs on focus
document.querySelectorAll('.form-control').forEach(input => {
    input.addEventListener('focus', function() {
        this.style.transform = 'translateY(-2px)';
    });
    
    input.addEventListener('blur', function() {
        this.style.transform = 'translateY(0)';
    });
});
</script>

<?php include 'includes/footer.php'; ?>
