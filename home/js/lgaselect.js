function getLgas(){
    var state = document.getElementById("states");
    var lgas = document.getElementById("lgas");
    var stateSelectedValue = state.options[state.selectedIndex].value;
    switch (stateSelectedValue){
        case "Abia" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Umuahia", "Umuahia" );
        break;       
        case "Adamawa" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Yola", "Yola" );
        break;
        case "Akwa-Ibom" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Uyo", "Uyo" );
        break;
        case "Anambra" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Awka", "Awka" );
        break;
        case "Bauchi" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Bauchi", "Bauchi" );
        break;
        case "Bayelsa" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Yenagoa", "Yenagoa" );
        break;
        case "Benue" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Makurdi", "Makurdi" );
        break;
        case "Borno" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Maiduguri", "Maiduguri" );
        break;
        case "Cross River" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Calabar", "Calabar" );
        break;
        case "Delta" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Asaba", "Asaba" );
        break;
        case "Ebonyi" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Abakiliki", "Abakiliki" );
        break;
        case "Edo" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Benin City", "Benin City" );
        break;
        case "Ekiti" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Ado-Ekiti", "Ado-Ekiti" );
        break;
        case "Enugu" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Enugu", "Enugu" );
        break;
        case "Gombe" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Gombe", "Gombe" );
        break;
        case "Imo" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Owerri", "Owerri" );
        break;
        case "Jigawa" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Dutse", "Dutse" );
        break;
        case "Kaduna" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Kaduna", "Kaduna" );
        break;
        case "Kano" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Kano", "Kano" );
        break;
        case "Katsina" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Katsina", "Katsina" );
        break;
        case "Kebbi" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Birnin Kebbi", "Birnin Kebbi" );
        break;
        case "Kogi" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Lokoja", "Lokoja" );
        break;
        case "Kwara" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Ilorin", "Ilorin" );
        break;
        case "Lagos" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Ikeja", "Ikeja" );
        break;
        case "Nassarawa" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Lafia", "Lafia" );
        break;
        case "Niger" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Minna", "Minna" );
        break;
        case "Ogun" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Abeokuta", "Abeokuta" );
        break;
        case "Ondo" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Akure", "Akure" );
        break;
        case "Osun" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Oshogbo", "Oshogbo" );
        break;
        case "Oyo" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Ibadan", "Ibadan" );
        break;
        case "Plateau" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Jos", "Jos" );
        break;
        case "Rivers" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Port-Harcourt", "Port-Harcourt" );
        break;
        case "Sokoto" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Sokoto", "Sokoto" );
        break;
        case "Taraba" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Jalingo", "Jalingo" );
        break;
        case "Yobe" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Damaturu", "Damaturu" );
        break;
        case "Zamfara" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Gusau", "Gusau" );
        break;
        case "FCT" :
            lgas.options.length = 0;
            lgas.options[0] = new Option ( "Select LGA", " " );
            lgas.options[1] = new Option ( "Abuja", "Abuja" );
        break;
    }
}