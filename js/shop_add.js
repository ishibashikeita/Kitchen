
function add_sec(){
    var section = document.createElement('section');
    section.className = 'intro_shop';
    var div1 = document.createElement('div');
    div1.className = 'intro_shop_img';
    var div2 = document.createElement('div');
    div2.className = 'intro_shop_info';
    var img = document.createElement('img');
    img.src = '';
    img.alt = '店舗画像';
    var div3 = document.createElement('div');
    div3.className = 'intro_shop_data';
    var h2 = document.createElement('h2');
    h2.textContent = '店舗';
    var h3 = document.createElement('h3');
    h3.textContent = '所在地';
    var div4 = document.createElement('div');
    div4.className = 'intro_morebt';
    
    var a_element = document.createElement('a');
    a_element.href = 's_main.php';

    var btn = document.createElement('button');
    btn.textContent = 'MORE➡';



    var text = document.getElementById('intro');
    text.appendChild(section);
    section.appendChild(div1);
    section.appendChild(div2);
    div1.appendChild(img);
    div2.appendChild(div3);
    div3.appendChild(h2);
    div3.appendChild(h3);
    div2.appendChild(div4);
    div4.appendChild(a_element);
    a_element.appendChild(btn);
    
    

}
