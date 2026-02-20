"use strict";

(function ($) {
    $(document).on("click", ".limoux-ai-generate", function () {
        const button = $(this);
        const postId = button.data("post-id");
        const contentType = button.data("content-type");

        button.prop("disabled", true);

        $.post(limouxAi.ajaxUrl, {
            action: "limoux_ai_generate",
            nonce: limouxAi.nonce,
            post_id: postId,
            content_type: contentType
        }).always(function () {
            button.prop("disabled", false);
        });
    });
}(jQuery));
