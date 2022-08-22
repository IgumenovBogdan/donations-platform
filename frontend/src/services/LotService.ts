import $api from "../http";
import {ILot} from "../models/ILot";

interface lotsResponse {
    data: ILot[]
}

export default class LotService {
    static async getLots(take: number, sortBy?: string, s?: string) {
        return $api.get<lotsResponse>
        ('/lots?take=' + take + '&order=' + sortBy + '&s=' + s )
    }
}