import $api from "../http";
import {ILot} from "../models/ILot";

interface lotsResponse {
    data: ILot[]
}

interface lotResponse {
    data: ILot
}

export default class LotService {
    static async getLots(take: number, sortBy?: string, s?: string) {
        return $api.get<lotsResponse>
        ('/lots?take=' + take + '&order=' + sortBy + '&s=' + s )
    }

    static async getLotsByOrganization(take: number, sortBy?: string, s?: string) {
        return $api.get<lotsResponse>
        ('organization/lots?take=' + take + '&order=' + sortBy + '&s=' + s )
    }

    static async create(data: {
        name?: string,
        description?: string,
        price?: string
    }) {
        return $api.post<lotResponse>
        ('/lots', data)
    }

    static async update(id: string, data: {
        name?: string,
        description?: string,
        price?: string
    }) {
        return $api.put<lotResponse>('/lots/' + id, data)
    }

    static async delete(id: string) {
        return $api.delete('/lots/' + id)
    }
}