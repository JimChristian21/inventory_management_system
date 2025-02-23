import { library} from '@fortawesome/fontawesome-svg-core'
import { faUserSecret } from '@fortawesome/free-solid-svg-icons';
import { faUsers } from '@fortawesome/free-solid-svg-icons';
import { faSort } from '@fortawesome/free-solid-svg-icons';

const icons = [
    faSort,
    faUserSecret,
    faUsers
];

icons.forEach((icon) => {

    library.add(icon);
});
