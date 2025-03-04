<?php
include("components/header.php")
?>
<!-- Slider -->
<section class="section-slide">
	<div class="wrap-slick1">
		<div class="slick1">
			<div class="item-slick1" style="background-image: url(images/ban3.png);">
				<div class="container h-full">
					<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
						<div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
							<span style="color: white;" class="ltext-101 cl2 respon2">
								Elevate Your Everyday Essentials
							</span>
						</div>

						<div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
							<h2 style="color: white;" class="ltext-201 cl2 p-t-19 p-b-43 respon1">
								Inspire Your Workspace
							</h2>
						</div>

						<div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
							<a style="color: white;" href="product.php" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
								Shop Now
							</a>
						</div>
					</div>
				</div>
			</div>

			<div class="item-slick1" style="background-image: url(images/ban2.jpeg);">
				<div class="container h-full">
					<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
						<div class="layer-slick1 animated visible-false" data-appear="rollIn" data-delay="0">
							<span style="color: white;" class="ltext-101 cl2 respon2">
								Your One-Stop Stationery Shop
							</span>
						</div>

						<div class="layer-slick1 animated visible-false" data-appear="lightSpeedIn" data-delay="800">
							<h2 style="color: white;" class="ltext-201 cl2 p-t-19 p-b-43 respon1">
								Organize. Create. Inspire.
							</h2>
						</div>

						<div class="layer-slick1 animated visible-false" data-appear="slideInUp" data-delay="1600">
							<a style="color: white;" href="product.php" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
								Shop Now
							</a>
						</div>
					</div>
				</div>
			</div>

			<div class="item-slick1" style="background-image: url(images/ban1.png);">
				<div class="container h-full">
					<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
						<div class="layer-slick1 animated visible-false" data-appear="rotateInDownLeft" data-delay="0">
							<span style="color: white;" class="ltext-101 cl2 respon2">
								Stationery That Makes a Statement
							</span>
						</div>

						<div class="layer-slick1 animated visible-false" data-appear="rotateInUpRight" data-delay="800">
							<h2 style="color: white;" class="ltext-201 cl2 p-t-19 p-b-43 respon1">
								Write Your Story in Style
							</h2>
						</div>

						<div class="layer-slick1 animated visible-false" data-appear="rotateIn" data-delay="1600">
							<a style="color: white;" href="product.php" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
								Shop Now
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<!-- Banner -->
<div class="sec-banner bg0 p-t-80 p-b-50">
	<div class="container">
		<h3 class="ltext-103 cl5 pb-4">
			CATEGORIES
		</h3>
		<div class="row">
			<?php
			$query = $pdo->query("select * from categories");
			$rows = $query->fetchALL(PDO::FETCH_ASSOC);
			foreach ($rows as $keys) {
			?>
				<div class="col-md-6 col-xl-4 p-b-30 m-lr-auto">
					<!-- Block1 -->
					<div class="block1 wrap-pic-w">
						<img style="height: 300px; width: 300px;" src="<?php echo $cataddress . $keys['image'] ?>" alt="IMG-BANNER">

						<a href="product.php?cid=<?php echo $keys['ctid'] ?>" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
							<div class="block1-txt-child1 flex-col-l">
								<span class="block1-name ltext-102 trans-04 p-b-8">
									<?php echo $keys['name'] ?>
								</span>
							</div>

							<div class="block1-txt-child2 p-b-4 trans-05">
								<div class="block1-link stext-101 cl0 trans-09">
									Shop Now
								</div>
							</div>
						</a>
					</div>
				</div>
			<?php
			}
			?>

		</div>
	</div>
</div>


<!-- Product -->
<section class="bg0 p-t-23 p-b-140">
    <div class="container">
        <div class="p-b-10">
            <h3 class="ltext-103 cl5">
                Product Overview
            </h3>
        </div>

        <div class="flex-w flex-sb-m p-b-52">
            <div class="flex-w flex-l-m filter-tope-group m-tb-10">
                <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1" data-filter="*">
                    All Products
                </button>

                <?php
                $query = $pdo->query("SELECT * FROM categories");
                $categories = $query->fetchAll(PDO::FETCH_ASSOC);

                foreach ($categories as $category) {
                    $categoryClass = strtolower(str_replace(' ', '-', $category['name'])); // Convert spaces to dashes
                    echo '<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 filter-btn" data-filter=".' . $categoryClass . '">';
                    echo htmlspecialchars($category['name']);
                    echo '</button>';
                }
                ?>
            </div>
        </div>

        <div class="row isotope-grid">
            <?php
            $allQuery = $pdo->query("SELECT * FROM products ORDER BY RAND()"); // Fetch products in random order
            $allrows = $allQuery->fetchAll(PDO::FETCH_ASSOC);

            foreach ($allrows as $allproduct) {
                // Fetch category name from the database
                $categoryQuery = $pdo->prepare("SELECT name FROM categories WHERE ctid  = ?");
                $categoryQuery->execute([$allproduct['categoryid']]);
                $category = $categoryQuery->fetch(PDO::FETCH_ASSOC);

                $categoryClass = strtolower(str_replace(' ', '-', $category['name'])); // Convert spaces to dashes
            ?>
                <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item <?php echo $categoryClass; ?>">
                    <div class="block2">
                        <div class="block2-pic hov-img0">
                            <img src="<?php echo $proaddress . $allproduct['image']; ?>" alt="IMG-PRODUCT">

                            <a href="product-detail.php?pid=<?php echo $allproduct['id']; ?>" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
                                Quick View
                            </a>
                        </div>

                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1 flex-col-l ">
                                <a href="product-detail.php?pid=<?php echo $allproduct['id']; ?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                    <?php echo $allproduct['name']; ?>
                                </a>

                                <span class="stext-105 cl3">
                                    PKR <?php echo $allproduct['price']; ?>
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
</section>

<?php
include("components/footer.php")
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