function clear(){
    document.myForm.first_name.parentNode.children[1].style.display = 'none'
    document.myForm.second_name.parentNode.children[1].style.display = 'none'
    document.myForm.email.parentNode.children[1].style.display = 'none'
    document.myForm.phone.parentNode.children[1].style.display = 'none'
    document.myForm.comm.parentNode.children[1].style.display = 'none'
    document.getElementById('dbcheck').style.display = 'none'
}

document.getElementById('sumbit_button').addEventListener('click',
    ()=>{
        clear()
        let Data = new FormData();

        let validate = {
            first_name: document.myForm.first_name.value.length !== 0,
            second_name: document.myForm.second_name.value.length !== 0,
            email: /^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,}$/i
                .test(document.myForm.email.value),
            phone: /(\+7|8)[- _]*\(?[- _]*(\d{3}[- _]*\)?([- _]*\d){7}|\d\d[- _]*\d\d[- _]*\)?([- _]*\d){6})$/
                .test(document.myForm.phone.value),
            comm: document.myForm.comm.value.length !==0

        }

        if(Object.values(validate).every(elem => elem)) {
            let Data = new FormData();
            Data.append("first_name", document.myForm.first_name.value);
            Data.append("second_name", document.myForm.second_name.value);
            Data.append("last_name", document.myForm.last_name.value);
            Data.append("email", document.myForm.email.value);
            Data.append("phone", document.myForm.phone.value);
            Data.append("comm", document.myForm.comm.value);

            fetch('app',{
                method: 'POST',
                body: Data,
            })
                .then((response) => {return response.json()})
                .then((jsonedResponse)=>{if(jsonedResponse.status){
                    alert('Вы успешно отправили заявку! С вами скоро свяжутся!');
                    document.getElementById('dbcheck').style.display = 'none';
                } else {
                    document.getElementById('dbcheck').style.display = 'block';
                    document.getElementById('dbcheck').innerHTML = 'Вы уже отправляли заявку с этой почты. ' +
                        'Следующую заявку с этой почты вы сможете отправить через ' + jsonedResponse.h.toString() + ' часов, '
                        + jsonedResponse.m.toString() + ' минут, ' + + jsonedResponse.s.toString() + ' секунд.';

                }})
        } else Object.keys(validate).forEach(x =>
            (validate[x] ? document.myForm[x].parentNode.children[1].style.display = 'none' : document.myForm[x].parentNode.children[1].style.display = 'block'))
    })
