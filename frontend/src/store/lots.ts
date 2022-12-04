import {ILot} from "../models/ILot";
import {makeAutoObservable} from "mobx";
import LotService from "../services/LotService";

export default class Lots {

    lots!: ILot[];
    error = '';
    isLoading = false;

    constructor() {
        makeAutoObservable(this);
    }

    setLots(lots: ILot[]) {
        this.lots = lots
    }

    setError(error: string) {
        this.error = error;
    }

    setLoading(bool: boolean) {
        this.isLoading = bool;
    }

    async getLots(take: number, sortBy?: string, s?: string) {
        this.setLoading(true)
        try {
            const response = await LotService.getLots(take, sortBy, s);
            this.setLots(response.data.data);
        } catch (e: any) {
            this.setError(e.response?.data?.message)
        } finally {
            this.setLoading(false)
        }
    }
}