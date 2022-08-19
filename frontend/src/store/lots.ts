import {ILot} from "../models/ILot";
import {makeAutoObservable} from "mobx";
import LotService from "../services/LotService";

export default class Lots {

    lots!: ILot[];
    error = '';

    constructor() {
        makeAutoObservable(this);
    }

    setLots(lots: ILot[]) {
        this.lots = lots
    }

    setError(error: string) {
        this.error = error;
    }

    async getLots() {
        try {
            const response = await LotService.getLots();
            this.setLots(response.data);
        } catch (e: any) {
            this.setError(e.response?.data?.message)
        }
    }

}