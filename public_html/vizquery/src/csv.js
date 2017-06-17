import Papaparse from "papaparse";
import { clone } from "./util";

export default function(results) {
    var results = clone(results).map((d) => {
        // REALLY UGLY CODE
        ['item', 'itemDescription', 'itemLabel'].forEach((key) => {
            d[key] = d[key] && d[key].value ? d[key].value : null;
        });

        return d;
    });

    var csv = Papaparse.unparse(results, {
        quotes : true
    });

    return `data:text/csv;charset=utf-8,${encodeURIComponent(csv)}`;
}