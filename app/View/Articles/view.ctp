<header>
    <div class="header-container">
    <a class="logo" href="index.html">
        <img
        class="logo-img"
        src="https://image.hoken-room.jp/asset/header_logo.svg"
        />
    </a>
    </div>
</header>
<div class="wrapper">
    <h1 style="font-size: 20px; display: inline">編集画面</h1>
    <h2><?php echo $article["Article"]["title"] ?></h2>
    <p><?php echo $article["Article"]["body"] ?></p>
    <div class="item-box">
    <div style="margin: 10px">
        <legend>テキストを入力</legend>
        <div class="edit-box">
        <form>
            <textarea
            class="form-control"
            id="new_item_comment"
            style="width: 90%; height: 50px; margin-bottom: 10px"
            ></textarea>
            <input id="new_item_article_id" type="hidden" value="<?php echo $article["Article"]["id"] ?>">
            <div>
            <input
                class="btn btn-primary item_submit"
                id="new_item_submit"
                type="button"
                value="保存する"
            />
            <input
                class="btn btn-default"
                type="reset"
                value="キャンセル"
            />
            </div>
        </form>
        </div>
        <div id="sortable">
        <?php foreach ($items as $index => $item): ?>
        <div class="item text-item" key="<?php echo $index ?>" item-id="<?php echo $item["Item"]["id"] ?>">
            <p style="margin: 0px"><?php echo $item["Item"]["comment"] ?></p>
            <ul class="editpager clearfix unvisible">
                <li class="first-order">一番上へ</li>
                <li class="minus-order">上へ</li>
                <li class="plus-order">下へ</li>
                <li class="last-order">一番下へ</li>
                <li class="edit-item">編集</li>
                <li class="delete-item">削除</li>
            </ul>
        </div>
        <?php endforeach; ?>
        </div>
    </div>
    </div>
</div>
<footer>
    <div class="footer-container">
    <ul class="footer-menu">
        <li>会社概要<span>|</span></li>
        <li>利用規約<span>|</span></li>
        <li>プライバシーポリシー</li>
    </ul>
    <p class="copyright">Copyright© Wizleap Inc. engineers.</p>
    </div>
</footer>
<script>
$("#new_item_submit").click(function (e) {
    e.preventDefault();
    var new_item_comment = $("#new_item_comment").val();
    var new_item_article_id = $("#new_item_article_id").val();
    $.ajax({
        type: "POST",
        url: "/blog/items/add",
        data: {
            comment: new_item_comment,
            article_id: new_item_article_id
        },
        success: function (data) {
            location.reload();
            $("#new_item_comment").val("");
        }
    });
});

$("#sortable").on(
  {
    mouseenter: function () {
      $(this).children(".editpager").removeClass("unvisible");
    },
    mouseleave: function () {
      $(this).children(".editpager").addClass("unvisible");
    },
  },
  ".item"
);

$("#sortable").on("click", ".first-order", function () {
  $(this).parent(".editpager").addClass("unvisible");
  var articleId = <?php echo $article["Article"]["id"] ?>;
  var moveFrom = Number($(this).parent(".editpager").parent(".item").attr("key"));
  var moveTo = 0;
  if(!(moveFrom == moveTo)) {
    $.ajax({
    type: "POST",
    url: "/blog/articles/move",
    data: {
      article_id: articleId,
      move_from: moveFrom,
      move_to: moveTo,
    },
    success: function (data) {
      location.reload();
    }
  });
  }
});

$("#sortable").on("click", ".minus-order", function () {
  $(this).parent(".editpager").addClass("unvisible");
  var articleId = <?php echo $article["Article"]["id"] ?>;
  var moveFrom =  Number($(this).parent(".editpager").parent(".item").attr("key"));
  if (moveFrom > 0) {
    var moveTo = moveFrom - 1;
    $.ajax({
    type: "POST",
    url: "/blog/articles/move",
    data: {
      article_id: articleId,
      move_from: moveFrom,
      move_to: moveTo,
    },
    success: function (data) {
      location.reload();
    }
  });
  }
});

$("#sortable").on("click", ".plus-order", function () {
  $(this).parent(".editpager").addClass("unvisible");
  var articleId = <?php echo $article["Article"]["id"] ?>;
  var moveFrom = Number($(this).parent(".editpager").parent(".item").attr("key"));
  console.log(moveFrom);
  if (moveFrom < Number(<?php echo count($items) ?>) - 1) {
    var moveTo = moveFrom + 1;
    $.ajax({
    type: "POST",
    url: "/blog/articles/move",
    data: {
      article_id: articleId,
      move_from: moveFrom,
      move_to: moveTo,
    },
    success: function (data) {
      location.reload();
    }
  });
  }
});

$("#sortable").on("click", ".last-order", function () {
  $(this).parent(".editpager").addClass("unvisible");
  var articleId = <?php echo $article["Article"]["id"] ?>;
  var moveFrom = Number($(this).parent(".editpager").parent(".item").attr("key"));
  var moveTo = <?php echo count($items) ?>;
  if(!(moveFrom == moveTo)) {
    $.ajax({
      type: "POST",
      url: "/blog/articles/move",
      data: {
        article_id: articleId,
        move_from: moveFrom,
        move_to: moveTo,
      },
      success: function (data) {
        location.reload();
      }
    });
  }
});

$("#sortable").on("click", ".delete-item", function () {
  if (confirm("本当に削除してよろしいですか？")) {
    $(this).parent(".editpager").addClass("unvisible");
    var itemId = $(this).parents(".item").attr("item-id");
    console.log(itemId);
    var articleId = <?php echo $article["Article"]["id"] ?>;
    $.ajax({
      type: "POST",
      url: "/blog/items/delete/" + itemId,
      data: {
        article_id: articleId,
      },
      success: function (data) {
        location.reload();
      }
    });
  }
});

$("#sortable").on("click", ".edit-item", function () {
  var ctx = $(this).parents(".item").children("p").text();
  var commentId = $(this).parents(".item").attr("item-id");
  $(this).parents(".item").children("p").remove();
  $(this).parents(".item").prepend(`
    <form item-id="${commentId}">
        <textarea id="edit_text" class='form-control'>${ctx}</textarea>
        <div>
            <input
                id="edit_submit"
                class="btn btn-primary item_submit"
                type="button"
                value="保存する"
            />
        </div>
    </form>
    `);
});

$("#sortable").on("click", "#edit_submit", function () {
  var ctx = $(this).parents("form").children("#edit_text").val();
  var itemId = $(this).parents("form").attr("item-id");
    $.ajax({
        type: "POST",
        url: `/blog/items/edit/${itemId}`,
        data: {
            comment: ctx,
        },
        success: function (data) {
            location.reload();
        }
    });
});
</script>