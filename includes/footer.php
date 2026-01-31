    </div>

    <!-- المودال السينمائي الاحترافي - Cinema Premium Modal -->
    <div class="custom-modal-backdrop" id="cinemaBackdrop">
        <div class="cinema-modal">
            <div id="cinemaIcon" class="success-checkmark">
                <!-- علامة الصح المتحركة (Default Success) -->
                <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" class="checkmark-svg">
                    <polyline points="20 6 9 17 4 12" style="stroke: #10b981;"></polyline>
                </svg>
            </div>
            
            <h2 class="modal-title fw-bolder text-white" id="cinemaTitle">تمت العملية</h2>
            <p class="modal-body fs-5" id="cinemaBody">تم تسجيل البيانات بنجاح في قاعدة البيانات.</p>
            
            <!-- أزرار التحكم في حالة التأكيد -->
            <div id="confirmActions" class="d-flex gap-3 justify-content-center hidden">
                <button class="btn btn-secondary px-4 fs-5" style="background: rgba(255,255,255,0.05); color: #fff;" onclick="dismissCinema()">تراجع</button>
                <button class="btn btn-primary px-5 fs-5" id="execCinemaBtn">نعم، متأكد</button>
            </div>

            <!-- أزرار التحكم في حالة النجاح -->
            <div id="successActions" class="d-flex justify-content-center">
                <button class="btn btn-primary px-5 fs-5" onclick="dismissCinema()">حسناً</button>
            </div>
        </div>
    </div>

    <!-- المكتبات الأساسية -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
