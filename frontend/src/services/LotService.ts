import $api from "../http";
import {ILot} from "../models/ILot";

export default class LotService {
    static async getLots() {
        return $api.get<ILot[]>('/lots')
    }
}