import { library} from '@fortawesome/fontawesome-svg-core'
import { 
    faUserSecret,
    faUsers, 
    faSort,
    faTrash,
    faPencilAlt,
    faWarehouse
} from '@fortawesome/free-solid-svg-icons';

const icons = [
    faSort,
    faUserSecret,
    faUsers,
    faTrash,
    faPencilAlt,
    faWarehouse
];

icons.forEach((icon) => {

    library.add(icon);
});
