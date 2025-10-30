class Erabiltzailea {
    constructor (id, erabiltzailea, email, izena, abizena, nan, adina) {
        this._id = id;
        this._erabiltzailea = erabiltzailea;
        this._email = email;
        this._izena = izena;
        this._abizena = abizena;
        this._nan = nan;
        this._adina = adina;
    }
    
    get id() {
        return this._id;
    }

    get erabiltzailea() {
        return this._erabiltzailea;
    }

    get email() {
        return this._email;
    }

    get izena() {
        return this._izena;
    }

    get abizena() {
        return this._abizena;
    }

    get nan() {
        return this._nan;
    }

    get adina() {
        return this._adina;
    }

    set erabiltzailea(erabiltzailea) {
        if (erabiltzailea != null) {
            this._erabiltzailea = erabiltzailea;
        }
    }

    set email(email) {
        if (email != null) {
            this._email = email;
        }
    }

    set izena(izena) {
        if (izena != null) {
            this._izena = izena;
        }
    }

    set abizena(abizena) {
        if (abizena != null) {
            this._abizena = abizena;
        }
    }

    set nan(nan) {
        if (nan != null) {
            this._nan = nan;
        }
    }

    set adina(adina) {
        if (adina != null) {
            this._adina = adina;
        }
    }

    toStringConsole() {
        return "Erabiltzailea: " + this._erabiltzailea + "\nEmail: " + this._email + "\nIzena: " + this._izena + "\nAbizena: " + this._abizena + "\nNAN: " + this._nan + "\nAdina: " + this._adina;
    }
}