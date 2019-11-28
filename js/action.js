$(document).ready(function(){
     //template
  var source = $('#todo-list-item-template').html(); //取出todo-list-item的html 存為source "html()"這種方式可以取出html裡原有的值
  var todoTemplate = Handlebars.compile(source); //將source compile過後 存為template

//prepare all todo list items  準備好todo
var todoListUI = ' ';//宣告一個空字串 準備套入todos的li
$.each(todos, function (index,  todo) { //這邊拆開todos 變成一個一個的todo
     todoListUI = todoListUI + todoTemplate(todo);//來這邊湊成一整個li 然後在塞到下面的語法
});
$('#todo-list').find('li.new').before(todoListUI);//指定在#todo-list的new-li之前插入todoListUI

  //create
//enter editor mode
$('#todo-list')
//.on 適用於提醒新增物件也該具備事件功能
.on("dblclick", ".content",  function(e){
$(this).prop('contenteditable', true).focus();//直接觸發動作(focus)
})
//create&update
.on('blur', '.content', function(e){
    //create&update的blur衝突修正,主要先做判斷式 判斷create&update
 var isNew =   $(this).closest('li').is('.new');//先找出create與update不一樣的地方 宣告變數
//做判斷式
//create
if (isNew) {
    var todo = $(e.currentTarget).text();//先找出li-new的content設定一個blur的事件,再宣告一個擷取內容的變數todo
    todo = todo.trim();//清掉content多餘的空白

    if (todo.length > 0) {//判斷todo的字串長度是否大於零
           var order = $('#todo-list').find('li:not(.new)').length +1;//抓取所以有li之後 再用length+1
        $.post("todo/create.php", {content: todo, order:order}, function (data, textStatus, XHR) {
                 todo = {
                     id: data.id, 
                     is_complete: false,
                     content: todo,
                 }; //content 所宣告的todo為最一開始宣告的,而現在再把todo宣告成另外一個值,覆寫原先todo的值
                 var li = todoTemplate(todo);
                 $(e.currentTarget).closest('li').before(li);
            },'json');
    }
    $(e.currentTarget).empty();//清掉li-new的內容
}
//update
else {
    //AJAX call
    var id = $(this).closest('li').data('id');
    var content = $(this).text();
    $.post('todo/update.php', {id: id, content: content});

    $(this).prop('contenteditable', false);
}
})
//delete
.on('click', '.delete', function(e){
    var result = confirm ('do you want to delete?');//confirm是一個彈跳式對話框
    if (result) {
      //AJAX call
      var id = $(this).closest('li').data('id');
      $.post('todo/delete.php', {id: id}, function(data, textStatus, xhr){
          $(e.currentTarget).closest('li').remove();//這邊的this已經變成function 所以要改使用e.currentTarget
      });
    }
})
//complete
.on('click', '.checkbox', function(e){
    //AJAX call
    var id = $(this).closest('li').data('id');
    $.post("todo/complete.php", {id: id}, function (data, textStatus, xhr) {
            $(e.currentTarget).closest('li').toggleClass('complete'); //toggleClass 一個開關的變數 
        });
});

$('#todo-list').find('ul').sortable({
   items: 'li:not(.new)' ,
   stop: function() {
       var orderPair = [ ];
       $('#todo-list').find('li:not(.new)').each (function(index, li){
           orderPair.push({
             id: $(li).data('id'),
             order: index +1,
           });
       });
       
       $.post('todo/sort.php', {orderPair: orderPair});  
   },
});
});