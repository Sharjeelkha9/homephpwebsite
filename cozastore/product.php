<?php
include("components/header.php");
?>

	<!-- Product -->
	<div class="bg0 m-t-80 p-b-140">
		<div class="container">
			<div class="flex-w flex-sb-m p-b-52">
			<?php
				if(!isset($_GET['cid'])){
?>
				<div class="flex-w flex-l-m filter-tope-group m-tb-10">
				<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1" data-filter="*">
					All Products
				</button>

				<?php
				$query = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
				$categories = $query->fetchAll(PDO::FETCH_ASSOC);

				foreach ($categories as $category) {
					$categoryClass = strtolower(str_replace(' ', '-', $category['name'])); // Convert spaces to dashes
					echo '<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 filter-btn" data-filter=".' . $categoryClass . '">';
					echo htmlspecialchars($category['name']);
					echo '</button>';
				}
				?>
				</div>
				<?php
				}
				?>
			</div>

			<div class="row isotope-grid">
    <?php
    if (isset($_GET['cid'])) {
        $cid = $_GET['cid'];
        $query = $pdo->prepare("SELECT * FROM products WHERE categoryid = :pid ORDER BY RAND()"); // Random order
        $query->bindParam(":pid", $cid);
        $query->execute();
        $products = $query->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $query = $pdo->query("SELECT * FROM products ORDER BY RAND()"); // Random order
        $products = $query->fetchAll(PDO::FETCH_ASSOC);
    }

    foreach ($products as $product) {
        // Fetch category name using `ctid`
        $categoryQuery = $pdo->prepare("SELECT name FROM categories WHERE ctid = ?");
        $categoryQuery->execute([$product['categoryid']]); // Ensure 'categoryid' matches 'ctid'
        $category = $categoryQuery->fetch(PDO::FETCH_ASSOC);

        if ($category) {
            $categoryClass = strtolower(str_replace(' ', '-', $category['name'])); // Convert spaces to dashes
        } else {
            $categoryClass = "uncategorized"; // Fallback if category not found
        }
    ?>
        <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item <?php echo $categoryClass; ?>">
            <div class="block2">
                <div class="block2-pic hov-img0">
                    <img src="<?php echo $proaddress . $product['image']; ?>" alt="IMG-PRODUCT">

                    <a href="product-detail.php?pid=<?php echo $product['id']; ?>" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
                        Quick View
                    </a>
                </div>

                <div class="block2-txt flex-w flex-t p-t-14">
                    <div class="block2-txt-child1 flex-col-l ">
                        <a href="product-detail.php?pid=<?php echo $product['id']; ?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                            <?php echo $product['name']; ?>
                        </a>

                        <span class="stext-105 cl3">
                            PKR <?php echo $product['price']; ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

			<!-- Load more -->
			<div class="flex-c-m flex-w w-full p-t-45">
				<a href="#" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
					Load More
				</a>
			</div>
		</div>
	</div>

<?php
include("components/footer.php");
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
	$(document).ready(function() {
		$(".filter-btn").click(function() {
			let filterClass = $(this).attr("data-filter");

			if (filterClass === "*") {
				$(".isotope-item").show();
			} else {
				$(".isotope-item").hide();
				$(filterClass).show();
			}
		});
	});
</script>
