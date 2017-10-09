new Vue({
    el: ".cars",
    data: {
        carSelected: false,
        isActive: true,
        hasError: false,
        id_car: '',
        brand: '',
        year: '',
        engine: '',
        color: '',
        speed: '',
        price: '',
        firstName: '',
        lastName: '',
        email: '',
        payment: 'card',
        errMessage: '',
        success: '',
        responseAjax: {},
        options: {
            brands: [
            {
                value: 'Bugatti',
                title: 'Bugatti'
            },
            {
                value: 'Rolls-Royce',
                title: 'Rolls-Royce'
            },
            {
                value: 'Jaguar',
                title: 'Jaguar'
            }
         ],
            years: [
            {
                value: '2011',
                title: '> 2011'
            },
            {
                value: '2010',
                title: '> 2010'
            },
            {
                value: '2009',
                title: '> 2009'
            }
        ],
            engines: [
            {
                value: '6000',
                title: '> 6000'
            },
            {
                value: '4000',
                title: '> 4000'
            },
            {
                value: '2000',
                title: '> 2000'
            }
        ],
            colors: [
            {
                value: 'white',
                title: 'white'
            },
            {
                value: 'black',
                title: 'black'
            },
            {
                value: 'yellow',
                title: 'yellow'
            }
        ],
            speeds: [
            {
                value: '300',
                title: '> 300'
            },
            {
                value: '250',
                title: '> 250'
            },
            {
                value: '200',
                title: '> 200'
            }
        ],
            prices: [
            {
                value: '1500000',
                title: '> 1 500 000'
            },
            {
                value: '900000',
                title: '> 900 000'
            },
            {
                value: '100000',
                title: '> 100 000'
            }
        ],
    }
    },
    created () {
        this.ajaxPost()
    },
    methods: {
        ajaxPost(params){
            var self = this
                var request = new XMLHttpRequest()
                request.responseType = 'text'
                request.onreadystatechange = function(){
                    if(request.readyState == 4 && request.status == 200){
                        self.responseAjax = JSON.parse(request.responseText)
                    }
                }

            request.open('POST', 'client.php')
                request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
                request.send(params)
        },
        openCar(id_car){
            this.errMessage = ''
                var postParams = 'id_car=' + id_car;
            this.ajaxPost(postParams)
                this.carSelected = true
                console.log(this.responseAjax)
        },
        filteredCars(){
            if(this.year != '')
            {
                this.carSelected = false 
                    var postParams = 'brand=' + this.brand + '&year=' + this.year + '&engine=' + this.engine + '&color=' + this.color + '&speed=' + this.speed + '&price=' + this.price;
                this.ajaxPost(postParams)
            }
        },
        checkForm() {
            if (this.checkFName() && this.checkLName() && this.checkEmail()){
                this.hasError = false
                    this.errMessage = "Thank you for your order"
                    var orderParams = 'fName=' + this.firstName + '&lName=' + this.lastName + '&email=' + this.email + '&payment=' + this.payment + '&id_car=' + this.responseAjax.id_car;
                console.log(orderParams)
                    this.ajaxPost(orderParams)

            }else{
                return false
            }
        },
        checkFName(){
            if (this.firstName.length > 3 ){
                this.errMessage = ""
                    return true
            }else{
                this.hasError = true;
                this.errMessage = "Invalid First Name"
            } 
        },
        checkLName(){
            if (this.lastName != ''){
                this.errMessage = ""
                    return true
            }else{
                this.hasError = true;
                this.errMessage = "Invalid Last Name"
            }      
        },
        checkEmail(){
            var re = /^[\w\.\d-_]+@[\w\.\d-_]+\.\w{2,4}$/i
            if (re.test(this.email)){
                this.errMessage = ""
                    return true
            }else{
                this.hasError = true;
                this.errMessage = "Invalid email"
            }
        } 
    }
})
