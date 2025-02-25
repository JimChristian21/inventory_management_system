import { library} from '@fortawesome/fontawesome-svg-core'
import { 
    faUserSecret,
    faUsers, 
    faSort 
} from '@fortawesome/free-solid-svg-icons';

const icons = [
    faSort,
    faUserSecret,
    faUsers
];

icons.forEach((icon) => {

    library.add(icon);
});
