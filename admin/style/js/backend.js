$(function () {
  "use strict";
  // $("select").selectBoxIt({
  //   autoWidth: false,
  //   showEffect: "fadeIn", // تأثير الظهور
  //   hideEffect: "fadeOut", // تأثير الاختفاء
  //   defaultText: "Select an Option", // نص افتراضي مع أيقونة
  //   theme: "bootstrap", // استخدام ثيم Bootstrap
  // });

  $("[placeholder]")
    .focus(function () {
      $(this).attr("data-text", $(this).attr("placeholder"));
      $(this).attr("placeholder", "");
    })
    .blur(function () {
      $(this).attr("placeholder", $(this).attr("data-text"));
    });

  $(".confirm").click(function (event) {
    if (!confirm("هل أنت متأكد أنك تريد الحذف؟")) {
      event.preventDefault(); // منع الإجراء الافتراضي إذا تم الضغط على "إلغاء"
    }
  });
});
